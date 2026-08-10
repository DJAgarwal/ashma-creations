<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\StaticPage;
use App\Services\HeroBannerService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $page = StaticPage::where('page_name', 'home')->first();

        // 0. Hero Banners via HeroBannerService
        $heroBanners = HeroBannerService::getHomepageBanners();

        // 1. Featured Collections with product counts
        $featuredCollections = Cache::remember('home_featured_collections_v1', 3600, function () {
            return Collection::active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
                ->take(6)
                ->get();
        });

        // 2. Shop by Category (Top-level categories with active children)
        $featuredCategories = Cache::remember('home_featured_categories_v1', 3600, function () {
            return Category::whereNull('parent_id')
                ->active()
                ->ordered()
                ->with(['children' => fn ($q) => $q->active()->ordered()->withCount(['products' => fn ($p) => $p->whereNull('deleted_at')])])
                ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
                ->take(6)
                ->get();
        });

        // 3. Featured Products eager loaded with primaryCategory & taxonomy tags
        $featuredProducts = Cache::remember('home_featured_products_v1', 3600, function () {
            $products = Product::where('is_featured', true)
                ->with(['primaryCategory', 'collections', 'occasions', 'recipients', 'styles', 'materials'])
                ->latest()
                ->take(8)
                ->get();

            if ($products->count() < 4) {
                $additional = Product::whereNotIn('id', $products->pluck('id'))
                    ->with(['primaryCategory', 'collections', 'occasions', 'recipients', 'styles', 'materials'])
                    ->latest()
                    ->take(8 - $products->count())
                    ->get();
                $products = $products->concat($additional);
            }

            return $products;
        });

        // 4. Shop by Occasion
        $occasions = Cache::remember('home_occasions_v2', 3600, function () {
            return Occasion::active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
                ->get();
        });

        // 5. Shop for Loved Ones
        $recipients = Cache::remember('home_recipients_v3', 3600, function () {
            return Recipient::active()
                ->ordered()
                ->withCount(['products' => fn ($q) => $q->whereNull('deleted_at')])
                ->get();
        });

        return view('pages.home', compact(
            'page',
            'heroBanners',
            'featuredCollections',
            'featuredCategories',
            'featuredProducts',
            'occasions',
            'recipients'
        ));
    }
}
