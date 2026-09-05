<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class GoogleFeedController extends Controller
{
    /**
     * Generate and return Google Merchant Center Product Feed (RSS 2.0 XML).
     */
    public function index(Request $request)
    {
        // Allow manual cache purge via ?refresh=1 or ?nocache=1
        if ($request->has('refresh') || $request->has('nocache')) {
            Cache::forget('google_merchant_feed_xml');
        }

        // Cache XML for 1 hour (auto-invalidated on product save/delete via FlushesHomeCache)
        $xml = Cache::remember('google_merchant_feed_xml', 3600, function () {
            $products = Product::with([
                'primaryCategory.parent',
                'occasions',
                'recipients',
                'styles',
                'materials',
                'collections',
            ])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

            return view('feeds.google-merchant', compact('products'))->render();
        });

        return Response::make($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'X-Robots-Tag' => 'noindex',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Resolve descriptive custom labels (0 to 4) for Google Shopping campaign segmentation.
     *
     * custom_label_0: Product Status / Promotion Badge (Featured, Best Seller, New Arrival, Trending)
     * custom_label_1: Pluralized Category / Item Type (e.g. Flower Keychains, Janmashtami Gifts, Mini Flower Pots)
     * custom_label_2: Occasion (e.g. Birthday, Janmashtami, Baby Shower)
     * custom_label_3: Target Recipient / Audience (e.g. Best Friend, Krishna, Kids)
     * custom_label_4: Craftsmanship & Origin (Handcrafted in India)
     */
    public static function resolveCustomLabels(Product $product): array
    {
        // 0. Status / Highlight Badge
        $badge = 'Featured';
        if (!empty($product->is_featured)) {
            $badge = 'Featured';
        } elseif (!empty($product->is_best_seller)) {
            $badge = 'Best Seller';
        } elseif (!empty($product->is_new_arrival)) {
            $badge = 'New Arrival';
        } elseif (!empty($product->is_trending)) {
            $badge = 'Trending';
        }

        // 1. Category / Product Type (Pluralized)
        if (!empty($product->primaryCategory?->name)) {
            $categoryType = Str::plural(trim($product->primaryCategory->name));
        } elseif (!empty($product->collections) && $product->collections->isNotEmpty()) {
            $categoryType = Str::plural(trim($product->collections->first()->name));
        } else {
            $categoryType = Str::plural(trim($product->name));
        }

        $title = strtolower(trim($product->name ?? ''));
        $catStr = strtolower(trim($product->primaryCategory?->name ?? ''));
        $titleAndCat = $title . ' ' . $catStr;
        $rawDesc = !empty($product->description) ? $product->description : (!empty($product->details) ? $product->details : $product->meta_description);
        $desc = strtolower(trim(strip_tags($rawDesc ?? '')));

        // 2. Occasion
        $matchOccasion = function (string $str): ?string {
            if (str_contains($str, 'janmashtami') || str_contains($str, 'krishna') || str_contains($str, 'kanha') || str_contains($str, 'laddu gopal') || str_contains($str, 'aasan')) return 'Janmashtami';
            if (str_contains($str, 'baby') || str_contains($str, 'shower') || str_contains($str, 'nursery') || str_contains($str, 'newborn')) return 'Baby Shower';
            if (str_contains($str, 'rakhi') || str_contains($str, 'rakshabandhan')) return 'Rakhi';
            if (str_contains($str, 'diwali') || str_contains($str, 'deepavali')) return 'Diwali';
            if (str_contains($str, 'valentine') || str_contains($str, 'romance')) return 'Valentine\'s Day';
            if (str_contains($str, 'mother')) return 'Mother\'s Day';
            if (str_contains($str, 'father')) return 'Father\'s Day';
            if (str_contains($str, 'birthday') || str_contains($str, 'bday')) return 'Birthday';
            if (str_contains($str, 'wedding') || str_contains($str, 'marriage') || str_contains($str, 'bridal')) return 'Wedding';
            if (str_contains($str, 'anniversary')) return 'Anniversary';
            if (str_contains($str, 'housewarming')) return 'Housewarming';
            if (str_contains($str, 'christmas') || str_contains($str, 'xmas')) return 'Christmas';
            if (str_contains($str, 'new year')) return 'New Year';
            if (str_contains($str, 'engagement')) return 'Engagement';
            if (str_contains($str, 'friendship')) return 'Friendship Day';
            if (str_contains($str, 'women')) return 'Women\'s Day';
            return null;
        };

        $occasion = $matchOccasion($titleAndCat);

        // If not matched in title or category, check attached occasions
        if (empty($occasion) && !empty($product->occasions) && $product->occasions->isNotEmpty()) {
            $occNames = $product->occasions->pluck('name')->toArray();
            if (count($occNames) <= 3) {
                $occasion = $occNames[0];
            } else {
                // If many attached (e.g. seeder attached all), prefer Birthday as universal gifting occasion
                $occasion = in_array('Birthday', $occNames) ? 'Birthday' : $occNames[0];
            }
        }

        if (empty($occasion)) {
            $occasion = $matchOccasion($desc) ?: 'Birthday';
        }

        // 3. Recipient / Audience
        $matchRecipient = function (string $str): ?string {
            if (str_contains($str, 'janmashtami') || str_contains($str, 'krishna') || str_contains($str, 'kanha') || str_contains($str, 'laddu gopal') || str_contains($str, 'bal gopal') || str_contains($str, 'aasan') || str_contains($str, 'poshak') || str_contains($str, 'puja') || str_contains($str, 'mandir')) return 'Krishna';
            if (str_contains($str, 'baby') || str_contains($str, 'kid') || str_contains($str, 'child') || str_contains($str, 'nursery') || str_contains($str, 'newborn') || str_contains($str, 'infant')) return 'Kids';
            if (str_contains($str, 'keychain') || str_contains($str, 'friend') || str_contains($str, 'best friend') || str_contains($str, 'bestie') || str_contains($str, 'bff')) return 'Best Friend';
            if (str_contains($str, 'mom') || str_contains($str, 'mother')) return 'Mom';
            if (str_contains($str, 'dad') || str_contains($str, 'father')) return 'Dad';
            if (str_contains($str, 'wife')) return 'Wife';
            if (str_contains($str, 'husband')) return 'Husband';
            if (str_contains($str, 'girlfriend')) return 'Girlfriend';
            if (str_contains($str, 'boyfriend')) return 'Boyfriend';
            if (str_contains($str, 'sister')) return 'Sister';
            if (str_contains($str, 'brother')) return 'Brother';
            if (str_contains($str, 'teacher')) return 'Teacher';
            if (str_contains($str, 'couple')) return 'Couples';
            if (str_contains($str, 'bride')) return 'Bride';
            if (str_contains($str, 'groom')) return 'Groom';
            if (str_contains($str, 'daughter')) return 'Daughter';
            if (str_contains($str, 'son')) return 'Son';
            return null;
        };

        $recipient = $matchRecipient($titleAndCat);

        // If not in title or category, check attached recipients
        if (empty($recipient) && !empty($product->recipients) && $product->recipients->isNotEmpty()) {
            $recNames = $product->recipients->pluck('name')->toArray();
            if (count($recNames) <= 3) {
                $recipient = $recNames[0];
            } else {
                // If many attached, prefer Best Friend or first
                $recipient = in_array('Best Friend', $recNames) ? 'Best Friend' : (in_array('Friends', $recNames) ? 'Friends' : $recNames[0]);
            }
        }

        if (empty($recipient)) {
            $recipient = $matchRecipient($desc) ?: 'Best Friend';
        }

        // 4. Origin & Craftsmanship
        $origin = 'Handcrafted in India';

        return [
            'custom_label_0' => $badge,
            'custom_label_1' => $categoryType,
            'custom_label_2' => $occasion,
            'custom_label_3' => $recipient,
            'custom_label_4' => $origin,
        ];
    }

    /**
     * Resolve valid official Google Product Taxonomy category path based on the product's actual function.
     */
    public static function resolveGoogleProductCategory(Product $product): string
    {
        // Build search string from category hierarchy and product name
        $categories = [];
        $curr = $product->primaryCategory;
        while ($curr) {
            array_unshift($categories, strtolower(trim($curr->name)));
            $curr = $curr->parent;
        }
        $catPathStr = implode(' ', $categories);
        $searchStr = strtolower(trim(($product->name ?? '') . ' ' . $catPathStr));

        // 1. Desk Organizers / Pen Stands (Office Supplies > Filing & Organization > Desk Organizers)
        if (str_contains($searchStr, 'pen stand') || str_contains($searchStr, 'pencil holder') || str_contains($searchStr, 'desk organizer') || str_contains($searchStr, 'pen holder') || str_contains($searchStr, 'stationery organizer')) {
            return 'Office Supplies > Filing & Organization > Desk Organizers';
        }

        // 2. Keychains / Bag Charms (Apparel & Accessories > Handbag & Wallet Accessories > Keychains)
        if (str_contains($searchStr, 'keychain') || str_contains($searchStr, 'key chain') || str_contains($searchStr, 'key ring') || str_contains($searchStr, 'bag charm') || str_contains($searchStr, 'key holder')) {
            return 'Apparel & Accessories > Handbag & Wallet Accessories > Keychains';
        }

        // 3. Curtain Holders / Tiebacks (Home & Garden > Decor > Window Treatment Accessories > Curtain Holdbacks & Tassels)
        if (str_contains($searchStr, 'curtain holder') || str_contains($searchStr, 'curtain tieback') || str_contains($searchStr, 'curtain tie back') || str_contains($searchStr, 'curtain holdback') || str_contains($searchStr, 'curtain')) {
            return 'Home & Garden > Decor > Window Treatment Accessories > Curtain Holdbacks & Tassels';
        }

        // 4. Religious Items / Aasans (Religious & Ceremonial > Religious Items)
        if (str_contains($searchStr, 'aasan') || str_contains($searchStr, 'asan') || str_contains($searchStr, 'janmashtami') || str_contains($searchStr, 'krishna') || str_contains($searchStr, 'laddu gopal') || str_contains($searchStr, 'pooja') || str_contains($searchStr, 'puja') || str_contains($searchStr, 'mandir') || str_contains($searchStr, 'poshak') || str_contains($searchStr, 'deity')) {
            return 'Religious & Ceremonial > Religious Items';
        }

        // 5. Photo Frames / Picture Frames (Home & Garden > Decor > Picture Frames)
        if (str_contains($searchStr, 'photo frame') || str_contains($searchStr, 'picture frame') || str_contains($searchStr, 'frame')) {
            return 'Home & Garden > Decor > Picture Frames';
        }

        // 6. Wall Hangings / Decorative Plaques (Home & Garden > Decor > Decorative Plaques)
        if (str_contains($searchStr, 'wall hanging') || str_contains($searchStr, 'name hanging') || str_contains($searchStr, 'wall plaque') || str_contains($searchStr, 'name plaque') || str_contains($searchStr, 'door hanging') || str_contains($searchStr, 'wall decor') || str_contains($searchStr, 'baby name')) {
            return 'Home & Garden > Decor > Decorative Plaques';
        }

        // 7. Potted Flowers, Flower Pots & Artificial Floral Arrangements (Home & Garden > Decor > Artificial Flora)
        if (str_contains($searchStr, 'flower pot') || str_contains($searchStr, 'tulip pot') || str_contains($searchStr, 'potted flower') || str_contains($searchStr, 'bouquet') || str_contains($searchStr, 'flower arrangement') || str_contains($searchStr, 'artificial flora') || str_contains($searchStr, 'flower stem') || str_contains($searchStr, 'artificial flower')) {
            return 'Home & Garden > Decor > Artificial Flora';
        }

        // 8. Empty Pots & Planters for Gardening (Home & Garden > Lawn & Garden > Gardening > Pots & Planters)
        if (str_contains($searchStr, 'planter') || str_contains($searchStr, 'plant pot') || str_contains($searchStr, 'gardening pot')) {
            return 'Home & Garden > Lawn & Garden > Gardening > Pots & Planters';
        }

        // 9. Hair Accessories
        if (str_contains($searchStr, 'hair clip') || str_contains($searchStr, 'headband') || str_contains($searchStr, 'hair accessory') || str_contains($searchStr, 'hair pin') || str_contains($searchStr, 'barrette')) {
            return 'Apparel & Accessories > Clothing Accessories > Hair Accessories';
        }

        // 10. Bookmarks
        if (str_contains($searchStr, 'bookmark')) {
            return 'Office Supplies > Book Accessories > Bookmarks';
        }

        // Default fallback to general Home & Garden > Decor
        return 'Home & Garden > Decor';
    }
}
