<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SchemaGenerator
{
    /**
     * Wrap entities into a standard Schema.org @graph JSON-LD structure.
     */
    public static function wrapInGraph(array $entities): array
    {
        return [
            '@context' => 'https://schema.org',
            '@graph' => array_values(array_filter($entities)),
        ];
    }

    /**
     * Reusable Logo ImageObject entity.
     */
    public static function logoImageEntity(): array
    {
        $logoUrl = url('/images/logo.webp');

        return [
            '@type' => 'ImageObject',
            '@id' => url('/') . '#logo',
            'url' => $logoUrl,
            'contentUrl' => $logoUrl,
            'name' => 'Ashma Creations Logo',
            'caption' => 'Ashma Creations Logo',
            'width' => 512,
            'height' => 512,
            'encodingFormat' => 'image/webp',
            'inLanguage' => 'en',
        ];
    }

    /**
     * Standard Organization entity for Ashma Creations.
     */
    public static function organizationEntity(bool $includeHasOfferCatalog = false): array
    {
        $org = [
            '@type' => 'Organization',
            '@id' => url('/') . '#organization',
            'name' => 'Ashma Creations',
            'url' => url('/'),
            'logo' => [
                '@id' => url('/') . '#logo',
            ],
            'image' => [
                '@id' => url('/') . '#logo',
            ],
            'inLanguage' => 'en',
            'knowsAbout' => [
                'Handmade Gifts',
                'Personalized Gifts',
                'Handcrafted Creations',
                'Handmade Home Decor',
                'Keepsakes',
                'Custom Gifts',
                'Floral Decor',
                'Pipe Cleaner Flowers',
                'Custom Floral Arrangements',
            ],
            'sameAs' => [
                'https://www.instagram.com/ashma_creations07',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'Customer Support',
                'email' => 'ashmacreations07@gmail.com',
                'telephone' => '+91-7728879509',
                'areaServed' => 'IN',
                'availableLanguage' => 'en',
            ],
            'description' => 'Ashma Creations creates thoughtful handmade gifts, personalized creations, home decor and unique keepsakes, handcrafted with care for special moments.',
        ];

        if ($includeHasOfferCatalog) {
            $org['hasOfferCatalog'] = [
                '@id' => url('/') . '#catalog',
            ];
        }

        return $org;
    }

    /**
     * Standard WebSite entity with SearchAction using EntryPoint and Organization publisher link.
     */
    public static function websiteEntity(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => url('/') . '#website',
            'url' => url('/'),
            'name' => 'Ashma Creations',
            'description' => 'Handcrafted pipe cleaner bouquets, flower pots, custom flower arrangements, and personalized gifts made with love by Ashma Creations.',
            'inLanguage' => 'en',
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/search') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * OfferCatalog entity for Homepage representing the complete discovery catalog hierarchy.
     */
    public static function offerCatalogEntity(): array
    {
        // 1. Categories
        $categoryItems = [];
        try {
            $topCategories = Category::whereNull('parent_id')->active()->ordered()->take(8)->get();
            foreach ($topCategories as $cat) {
                $categoryItems[] = [
                    '@type' => 'OfferCatalog',
                    'name' => $cat->name,
                    'description' => $cat->meta_description ?? ($cat->description ?? "Handcrafted {$cat->name} and decorative arrangements."),
                    'url' => route('categories.show', $cat->slug),
                ];
            }
        } catch (\Throwable $e) {}

        if (empty($categoryItems)) {
            $categoryItems = [
                ['@type' => 'OfferCatalog', 'name' => 'Bouquets', 'description' => 'Everlasting handcrafted pipe cleaner flower bouquets.', 'url' => url('/category/bouquets')],
                ['@type' => 'OfferCatalog', 'name' => 'Flower Pots', 'description' => 'Charming handmade flower pots for home decor.', 'url' => url('/category/flower-pots')],
            ];
        }

        // 2. Collections
        $collectionItems = [];
        try {
            $cols = Collection::active()->ordered()->take(8)->get();
            foreach ($cols as $col) {
                $collectionItems[] = [
                    '@type' => 'OfferCatalog',
                    'name' => $col->name,
                    'description' => $col->seo_description ?? ($col->description ?? "Curated {$col->name} collection of handmade creations."),
                    'url' => route('collections.show', $col->slug),
                ];
            }
        } catch (\Throwable $e) {}

        if (empty($collectionItems)) {
            $collectionItems = [
                ['@type' => 'OfferCatalog', 'name' => 'Featured Collection', 'description' => 'Our premier handcrafted flower arrangements.', 'url' => url('/collections')],
            ];
        }

        // 3. Occasions
        $occasionItems = [];
        try {
            $occs = \App\Models\Occasion::active()->ordered()->take(8)->get();
            foreach ($occs as $occ) {
                $occasionItems[] = [
                    '@type' => 'OfferCatalog',
                    'name' => $occ->name,
                    'description' => "Handmade gifts specially crafted for {$occ->name} celebrations.",
                    'url' => route('occasions.show', $occ->slug),
                ];
            }
        } catch (\Throwable $e) {}

        // 4. Recipients
        $recipientItems = [];
        try {
            $recs = \App\Models\Recipient::active()->ordered()->take(8)->get();
            foreach ($recs as $rec) {
                $recipientItems[] = [
                    '@type' => 'OfferCatalog',
                    'name' => $rec->name,
                    'description' => "Thoughtful personalized handmade gifts for {$rec->name}.",
                    'url' => route('recipients.show', $rec->slug),
                ];
            }
        } catch (\Throwable $e) {}

        $itemList = [];

        if (!empty($categoryItems)) {
            $itemList[] = [
                '@type' => 'OfferCatalog',
                'name' => 'Categories',
                'description' => 'Explore our handcrafted product categories.',
                'url' => route('categories.index'),
                'itemListElement' => $categoryItems,
            ];
        }

        if (!empty($collectionItems)) {
            $itemList[] = [
                '@type' => 'OfferCatalog',
                'name' => 'Collections',
                'description' => 'Curated handmade gift collections for every season.',
                'url' => route('collections.index'),
                'itemListElement' => $collectionItems,
            ];
        }

        if (!empty($occasionItems)) {
            $itemList[] = [
                '@type' => 'OfferCatalog',
                'name' => 'Occasions',
                'description' => 'Discover handmade gifts for every celebration and occasion.',
                'url' => route('occasions.index'),
                'itemListElement' => $occasionItems,
            ];
        }

        if (!empty($recipientItems)) {
            $itemList[] = [
                '@type' => 'OfferCatalog',
                'name' => 'Recipients',
                'description' => 'Browse handmade gifts organized by recipient.',
                'url' => route('recipients.index'),
                'itemListElement' => $recipientItems,
            ];
        }

        return [
            '@type' => 'OfferCatalog',
            '@id' => url('/') . '#catalog',
            'name' => 'Ashma Creations Catalog',
            'description' => 'Our complete catalog of handcrafted pipe cleaner flowers, bouquets, pots, and customized gifts.',
            'url' => url('/'),
            'inLanguage' => 'en',
            'itemListElement' => $itemList,
        ];
    }

    /**
     * Generate BreadcrumbList entity from a list of breadcrumb items with @id.
     * Items format: [['name' => 'Home', 'url' => url('/')], ...]
     */
    public static function breadcrumbListEntity(array $items, ?string $pageUrl = null): array
    {
        $elements = [];
        foreach ($items as $index => $item) {
            $elements[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        $url = $pageUrl ?? url('/');

        return [
            '@type' => 'BreadcrumbList',
            '@id' => $url . '#breadcrumb',
            'itemListElement' => $elements,
        ];
    }

    /**
     * Generate JSON-LD graph for Static Pages based on schema_type or page_name.
     */
    public static function forStaticPage(StaticPage $page): array
    {
        $schemaType = strtolower($page->schema_type ?? $page->page_name);
        $canonicalUrl = match ($page->page_name) {
            'home' => url('/'),
            'categories' => route('categories.index'),
            default => url('/' . $page->page_name),
        };

        return match ($schemaType) {
            'homepage', 'home' => static::forHomepage($page, $canonicalUrl),
            'about' => static::forAboutPage($page, $canonicalUrl),
            'contact' => static::forContactPage($page, $canonicalUrl),
            'faq' => static::forFaqPage($page, $canonicalUrl),
            default => static::forGenericStaticPage($page, $canonicalUrl),
        };
    }

    /**
     * Generate Homepage JSON-LD: WebPage + Organization + WebSite + BreadcrumbList + OfferCatalog + ImageObject.
     */
    protected static function forHomepage(StaticPage $page, string $canonicalUrl): array
    {
        $datePublished = $page->created_at ? $page->created_at->toIso8601String() : date('c');
        $dateModified = $page->updated_at ? $page->updated_at->toIso8601String() : $datePublished;

        $webPage = [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $page->meta_title ?? 'Home Page - Ashma Creations',
            'description' => $page->meta_description ?? 'Discover handmade pipe cleaner bouquets, flower pots, and personalized gifts.',
            'inLanguage' => 'en',
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'about' => [
                '@type' => 'Thing',
                'name' => 'Ashma Creations Homepage',
            ],
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'mainEntity' => [
                '@id' => url('/') . '#catalog',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        $breadcrumbs = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $webPage,
            static::logoImageEntity(),
            static::organizationEntity(true),
            static::websiteEntity(),
            $breadcrumbs,
            static::offerCatalogEntity(),
        ]);
    }

    /**
     * Generate About Page JSON-LD: AboutPage + Organization + WebSite + BreadcrumbList + ImageObject.
     */
    protected static function forAboutPage(StaticPage $page, string $canonicalUrl): array
    {
        $datePublished = $page->created_at ? $page->created_at->toIso8601String() : date('c');
        $dateModified = $page->updated_at ? $page->updated_at->toIso8601String() : $datePublished;

        $aboutPage = [
            '@type' => 'AboutPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $page->meta_title ?? 'About Us - Ashma Creations',
            'description' => $page->meta_description ?? 'Learn about Ashma Creations — platform for handmade creations and customized gifts.',
            'inLanguage' => 'en',
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'about' => [
                '@type' => 'Thing',
                'name' => 'About Us',
            ],
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'mainEntity' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        $breadcrumbs = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'About Us', 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $aboutPage,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
            $breadcrumbs,
        ]);
    }

    /**
     * Generate Contact Page JSON-LD: ContactPage + Organization + WebSite + BreadcrumbList + ImageObject.
     */
    protected static function forContactPage(StaticPage $page, string $canonicalUrl): array
    {
        $datePublished = $page->created_at ? $page->created_at->toIso8601String() : date('c');
        $dateModified = $page->updated_at ? $page->updated_at->toIso8601String() : $datePublished;

        $contactPage = [
            '@type' => 'ContactPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $page->meta_title ?? 'Contact Us - Ashma Creations',
            'description' => $page->meta_description ?? 'Get in touch with Ashma Creations for inquiries, custom orders, or feedback.',
            'inLanguage' => 'en',
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'about' => [
                '@type' => 'Thing',
                'name' => 'Contact Us',
            ],
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'mainEntity' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        $breadcrumbs = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Contact Us', 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $contactPage,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
            $breadcrumbs,
        ]);
    }

    /**
     * Generate FAQ Page JSON-LD: FAQPage + Organization + WebSite + BreadcrumbList + ImageObject.
     */
    protected static function forFaqPage(StaticPage $page, string $canonicalUrl): array
    {
        $datePublished = $page->created_at ? $page->created_at->toIso8601String() : date('c');
        $dateModified = $page->updated_at ? $page->updated_at->toIso8601String() : $datePublished;

        $faqQuestions = [
            [
                '@type' => 'Question',
                'name' => 'What materials are used to make Ashma Creations\' flowers and gifts?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Our flowers and decor pieces are meticulously handcrafted using high-density chenille pipe cleaners, soft plush fibers, durable floral wire stems, and high-quality ceramic or woven pots. This ensures every creation is soft, durable, flexible, and retains vibrant color forever without fading or requiring water.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can I request a custom color, bouquet design, or personalized gift?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes! We specialize in custom and personalized orders. You can customize flower types, color palettes, bouquet sizes, stem counts, and special gift wrapping. Contact us via WhatsApp (+91 7728879509) or Instagram (@ashma_creations07) with your ideas, and we will craft it for you.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Are pipe cleaner flowers suitable for allergies or eco-conscious gifting?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes! Unlike natural cut flowers that produce pollen and wither quickly, our handmade pipe cleaner flowers are 100% hypoallergenic, pollen-free, durable, and reusable for years as beautiful room decor.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How do I clean and care for pipe cleaner flowers?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Caring for everlasting handmade flowers is very simple! Keep them away from direct water or heavy moisture. To clean ambient dust over time, gently use a hairdryer on a cool/low setting or lightly dust them with a soft brush.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Will the colors fade or the pipe cleaners shed over time?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'No! We use premium high-density, color-fast plush chenille fibers. As long as they are kept away from direct prolonged soaking water, the colors stay vibrant and plush fibers remain firmly bound to the wire core.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How long does it take to create and deliver my order?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Creation time typically takes 2 to 4 business days because each piece is handcrafted individually with care. Once ready and securely packaged, shipping within India usually takes 3 to 7 business days, and we share tracking info with you directly.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How are fragile handmade flower pots and bouquets packaged for shipping?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Every creation is securely wrapped in multiple protective layers of bubble wrap, cushioned with eco-friendly filler, and placed in sturdy corrugated shipping boxes to ensure safe transit across India.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Do you accept urgent or bulk orders for events and weddings?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes! We accommodate bulk orders for wedding favors, return gifts, birthdays, and corporate events. Please contact us on WhatsApp (+91 7728879509) at least 1 to 2 weeks in advance so we can plan creation timelines.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What is your return and cancellation policy for handmade items?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Because our products are made-to-order and handcrafted, standard returns for buyer change-of-mind are not available. However, if an item arrives damaged during transit, contact us via WhatsApp or Email within 24 hours of delivery with photos/videos for a prompt replacement or solution.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'What payment methods do you accept for custom orders?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'We accept all major Indian payment options including UPI (GPay, PhonePe, Paytm), Net Banking, Credit/Debit Cards, and direct WhatsApp invoice payments.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can I send an order directly as a gift with a custom handwritten message?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes! We offer special gift wrapping and can enclose a beautifully handwritten card with your personalized message directly to the recipient\'s address.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Do you ship internationally outside India?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Currently, we primarily ship across India. If you require international shipping, please contact us on WhatsApp (+91 7728879509) to check custom shipping rates and delivery estimates for your destination.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Are pipe cleaner bouquets heavy or fragile to hold?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Not at all! Our bouquets are surprisingly lightweight because pipe cleaners and floral wire are easy to hold for long durations during photoshoots, graduations, or weddings without causing fatigue.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'How do I track my dispatched order?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Once your order is dispatched, we send your tracking number and courier link via SMS, Email, or WhatsApp so you can track your delivery step-by-step.',
                ],
            ],
            [
                '@type' => 'Question',
                'name' => 'Can I order matching accessories like mini flower pots or hair pins?',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => 'Yes! In addition to full-sized bouquets and pots, we craft mini desk pots, flower keychains, hair accessories, and table arrangements upon request.',
                ],
            ],
        ];

        $faqPage = [
            '@type' => 'FAQPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $page->meta_title ?? 'Frequently Asked Questions - Ashma Creations',
            'description' => $page->meta_description ?? 'Find answers to common questions about Ashma Creations handmade flowers, custom orders, care instructions, shipping, and returns.',
            'inLanguage' => 'en',
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'about' => [
                '@type' => 'Thing',
                'name' => 'Frequently Asked Questions',
            ],
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
            'mainEntity' => $faqQuestions,
        ];

        $breadcrumbs = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'FAQ', 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $faqPage,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
            $breadcrumbs,
        ]);
    }

    /**
     * Fallback for generic static pages: WebPage + Organization + WebSite + BreadcrumbList + ImageObject.
     */
    protected static function forGenericStaticPage(StaticPage $page, string $canonicalUrl): array
    {
        $datePublished = $page->created_at ? $page->created_at->toIso8601String() : date('c');
        $dateModified = $page->updated_at ? $page->updated_at->toIso8601String() : $datePublished;

        $aboutName = match ($page->page_name) {
            'terms-and-conditions' => 'Terms and Conditions',
            'privacy-policy' => 'Privacy Policy',
            'disclaimer' => 'Disclaimer',
            'categories' => 'Product Categories',
            default => ucwords(str_replace('-', ' ', $page->page_name)),
        };

        $webPage = [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $page->meta_title ?? (ucwords(str_replace('-', ' ', $page->page_name)) . ' - Ashma Creations'),
            'description' => $page->meta_description ?? ('Information about ' . $page->page_name . ' at Ashma Creations.'),
            'inLanguage' => 'en',
            'datePublished' => $datePublished,
            'dateModified' => $dateModified,
            'about' => [
                '@type' => 'Thing',
                'name' => $aboutName,
            ],
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        $breadcrumbs = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => ucwords(str_replace('-', ' ', $page->page_name)), 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $webPage,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
            $breadcrumbs,
        ]);
    }

    /**
     * Generate Products Catalog Page (/products) JSON-LD:
     * CollectionPage + ItemList + BreadcrumbList + Organization + WebSite + ImageObject.
     */
    public static function forCatalog($products = null, ?string $pageTitle = null, ?string $metaDescription = null): array
    {
        $canonicalUrl = route('products.index');

        $name = $pageTitle ?? 'All Handcrafted Products - Ashma Creations';
        $description = $metaDescription ?? 'Shop handmade pipe cleaner flowers, bouquets, flower pots and personalized gifts from Ashma Creations. Discover unique handcrafted gifts for every occasion.';

        // 1. CollectionPage Entity
        $collectionPageEntity = [
            '@type' => 'CollectionPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $name,
            'description' => $description,
            'inLanguage' => 'en',
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntity' => [
                '@id' => $canonicalUrl . '#itemlist',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        // 2. ItemList Entity (Dynamically generated from current paginated products)
        $itemListElement = [];
        if (!empty($products)) {
            $items = is_array($products) ? $products : ($products instanceof \Illuminate\Support\Collection ? $products : $products->items());
            foreach ($items as $index => $prod) {
                if ($prod instanceof Product) {
                    $itemListElement[] = [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => route('products.show', $prod->slug),
                        'name' => $prod->name,
                    ];
                }
            }
        }

        $itemListEntity = [
            '@type' => 'ItemList',
            '@id' => $canonicalUrl . '#itemlist',
            'name' => 'Ashma Creations Products',
            'numberOfItems' => count($itemListElement),
            'itemListElement' => $itemListElement,
        ];

        // 3. BreadcrumbList Entity
        $breadcrumbItems = [
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'All Products', 'url' => $canonicalUrl],
        ];

        $breadcrumbsEntity = static::breadcrumbListEntity($breadcrumbItems, $canonicalUrl);

        return static::wrapInGraph([
            $collectionPageEntity,
            $itemListEntity,
            $breadcrumbsEntity,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
        ]);
    }

    /**
     * Generate Product Page JSON-LD: Product + Offer (when valid) + ImageObject + BreadcrumbList.
     */
    public static function forProduct(Product $product): array
    {
        $canonicalUrl = route('products.show', $product->slug);

        // Images formatting
        $imagesList = [];
        if (!empty($product->images) && is_array($product->images)) {
            foreach ($product->images as $img) {
                $imagesList[] = filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img);
            }
        }
        if (empty($imagesList)) {
            $imagesList[] = url('/images/logo.webp');
        }

        $primaryImageUrl = $imagesList[0];
        $imageId = $primaryImageUrl . '#primaryimage';

        // Breadcrumbs
        $breadcrumbItems = [
            ['name' => 'Home', 'url' => url('/')],
        ];

        if ($product->primaryCategory) {
            if ($product->primaryCategory->parent) {
                $breadcrumbItems[] = [
                    'name' => $product->primaryCategory->parent->name,
                    'url' => route('categories.show', $product->primaryCategory->parent->slug),
                ];
            }
            $breadcrumbItems[] = [
                'name' => $product->primaryCategory->name,
                'url' => route('categories.show', $product->primaryCategory->slug),
            ];
        }

        $breadcrumbItems[] = [
            'name' => $product->name,
            'url' => $canonicalUrl,
        ];

        // 1. WebPage Entity
        $webPageEntity = [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => ($product->meta_title ?? $product->name) . ' - Ashma Creations',
            'description' => $product->meta_description ?? ($product->description ?? 'Handcrafted ' . $product->name . ' by Ashma Creations.'),
            'inLanguage' => 'en',
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => $imageId,
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        // 2. Product Entity
        $productEntity = [
            '@type' => 'Product',
            '@id' => $canonicalUrl . '#product',
            'name' => $product->name,
            'description' => $product->meta_description ?? ($product->description ?? 'Handcrafted ' . $product->name . ' by Ashma Creations.'),
            'image' => $imagesList,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'Ashma Creations',
            ],
        ];

        $offerData = [
            '@type' => 'Offer',
            'url' => $canonicalUrl,
            'availability' => 'https://schema.org/InStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'Ashma Creations',
            ],
        ];

        if (isset($product->price) && (float)$product->price > 0) {
            $offerData['priceCurrency'] = $product->currency ?? 'INR';
            $offerData['price'] = number_format((float)$product->price, 2, '.', '');
            $offerData['priceValidUntil'] = date('Y-12-31', strtotime('+1 year'));
        }

        $productEntity['offers'] = $offerData;

        // 3. ImageObject Entity (describing primary image)
        $imageObjectEntity = [
            '@type' => 'ImageObject',
            '@id' => $imageId,
            'url' => $primaryImageUrl,
            'contentUrl' => $primaryImageUrl,
            'caption' => $product->name,
            'inLanguage' => 'en',
            'representativeOfPage' => true,
        ];

        // 4. BreadcrumbList Entity
        $breadcrumbsEntity = static::breadcrumbListEntity($breadcrumbItems, $canonicalUrl);

        return static::wrapInGraph([
            $webPageEntity,
            $productEntity,
            $imageObjectEntity,
            $breadcrumbsEntity,
            static::logoImageEntity(),
            static::organizationEntity(),
            static::websiteEntity(),
        ]);
    }

    /**
     * Generate Taxonomy Listing Page JSON-LD (Category, Collection, Occasion, Recipient, Style, Material):
     * CollectionPage + ItemList + BreadcrumbList + ImageObject.
     */
    public static function forTaxonomy(Model $taxonomy, $products = null): array
    {
        $type = strtolower(class_basename(get_class($taxonomy)));
        $pluralType = Str::plural($type);

        $canonicalUrl = match ($type) {
            'category' => route('categories.show', $taxonomy->slug),
            'collection' => route('collections.show', $taxonomy->slug),
            'occasion' => route('occasions.show', $taxonomy->slug),
            'recipient' => route('recipients.show', $taxonomy->slug),
            'style' => route('styles.show', $taxonomy->slug),
            'material' => route('materials.show', $taxonomy->slug),
            default => url("/{$type}/{$taxonomy->slug}"),
        };

        $indexUrl = match ($type) {
            'category' => route('categories.index'),
            'collection' => route('collections.index'),
            'occasion' => route('occasions.index'),
            'recipient' => route('recipients.index'),
            default => url('/'),
        };

        $name = $taxonomy->meta_title ?? ($taxonomy->seo_title ?? ($taxonomy->name . ' - Ashma Creations'));
        $description = $taxonomy->meta_description ?? ($taxonomy->seo_description ?? ($taxonomy->description ?? 'Explore our ' . $taxonomy->name . ' collection at Ashma Creations.'));

        // 1. CollectionPage Entity
        $collectionPageEntity = [
            '@type' => 'CollectionPage',
            '@id' => $canonicalUrl,
            'url' => $canonicalUrl,
            'name' => $name,
            'description' => $description,
            'inLanguage' => 'en',
            'isPartOf' => [
                '@id' => url('/') . '#website',
            ],
            'publisher' => [
                '@id' => url('/') . '#organization',
            ],
            'primaryImageOfPage' => [
                '@id' => url('/') . '#logo',
            ],
            'breadcrumb' => [
                '@id' => $canonicalUrl . '#breadcrumb',
            ],
            'mainEntityOfPage' => $canonicalUrl,
        ];

        // 2. ItemList Entity (Only active & visible products currently shown)
        $itemListElement = [];
        if (!empty($products)) {
            $items = is_array($products) ? $products : ($products instanceof \Illuminate\Support\Collection ? $products : $products->items());
            foreach ($items as $index => $prod) {
                if ($prod instanceof Product) {
                    $itemListElement[] = [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'url' => route('products.show', $prod->slug),
                        'name' => $prod->name,
                    ];
                }
            }
        }

        $itemListEntity = [
            '@type' => 'ItemList',
            '@id' => $canonicalUrl . '#itemlist',
            'numberOfItems' => count($itemListElement),
            'itemListElement' => $itemListElement,
        ];

        // 3. BreadcrumbList Entity
        $breadcrumbItems = [
            ['name' => 'Home', 'url' => url('/')],
        ];

        if ($type === 'category' && isset($taxonomy->parent) && $taxonomy->parent) {
            $breadcrumbItems[] = [
                'name' => 'Categories',
                'url' => $indexUrl,
            ];
            $breadcrumbItems[] = [
                'name' => $taxonomy->parent->name,
                'url' => route('categories.show', $taxonomy->parent->slug),
            ];
        } elseif ($indexUrl !== url('/')) {
            $breadcrumbItems[] = [
                'name' => ucfirst($pluralType),
                'url' => $indexUrl,
            ];
        }

        $breadcrumbItems[] = [
            'name' => $taxonomy->name,
            'url' => $canonicalUrl,
        ];

        $breadcrumbsEntity = static::breadcrumbListEntity($breadcrumbItems, $canonicalUrl);

        return static::wrapInGraph([
            $collectionPageEntity,
            $itemListEntity,
            $breadcrumbsEntity,
            static::logoImageEntity(),
        ]);
    }

    public static function forCategory(Category $category, $products = null): array
    {
        return static::forTaxonomy($category, $products);
    }

    public static function forCollection(Collection $collection, $products = null): array
    {
        return static::forTaxonomy($collection, $products);
    }

    public static function forOccasion(Model $occasion, $products = null): array
    {
        return static::forTaxonomy($occasion, $products);
    }

    public static function forRecipient(Model $recipient, $products = null): array
    {
        return static::forTaxonomy($recipient, $products);
    }

    public static function forStyle(Model $style, $products = null): array
    {
        return static::forTaxonomy($style, $products);
    }

    public static function forMaterial(Model $material, $products = null): array
    {
        return static::forTaxonomy($material, $products);
    }

    /**
     * Future Blog / Article JSON-LD: Article + BreadcrumbList + ImageObject.
     */
    public static function forArticle(object $article): array
    {
        $canonicalUrl = $article->url ?? url('/blog/' . ($article->slug ?? ''));
        $imageUrl = $article->image_url ?? url('/images/logo.webp');

        $articleEntity = [
            '@type' => 'Article',
            '@id' => $canonicalUrl,
            'headline' => $article->title ?? '',
            'description' => $article->meta_description ?? ($article->summary ?? ''),
            'image' => $imageUrl,
            'inLanguage' => 'en',
            'datePublished' => $article->published_at ?? date('c'),
            'dateModified' => $article->updated_at ?? date('c'),
            'author' => [
                '@type' => 'Person',
                'name' => $article->author_name ?? 'Ashma Creations',
            ],
            'publisher' => static::organizationEntity(),
            'mainEntityOfPage' => $canonicalUrl,
        ];

        $imageObjectEntity = [
            '@type' => 'ImageObject',
            '@id' => $imageUrl . '#primaryimage',
            'url' => $imageUrl,
            'contentUrl' => $imageUrl,
            'caption' => $article->title ?? '',
            'inLanguage' => 'en',
            'representativeOfPage' => true,
        ];

        $breadcrumbsEntity = static::breadcrumbListEntity([
            ['name' => 'Home', 'url' => url('/')],
            ['name' => 'Blog', 'url' => url('/blog')],
            ['name' => $article->title ?? 'Article', 'url' => $canonicalUrl],
        ], $canonicalUrl);

        return static::wrapInGraph([
            $articleEntity,
            $imageObjectEntity,
            $breadcrumbsEntity,
        ]);
    }
}
