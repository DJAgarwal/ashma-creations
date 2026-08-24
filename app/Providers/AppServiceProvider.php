<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\StaticPage;
use App\Services\IndexNowService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IndexNowService::class, function () {
            return new IndexNowService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $pingIndexNow = function (string $url) {
            try {
                app(IndexNowService::class)->submitUrl($url);
            } catch (\Throwable $e) {
                // Silently continue so saving never gets blocked
            }
        };

        Product::saved(function ($product) use ($pingIndexNow) {
            $pingIndexNow(route('products.show', $product->slug));
        });

        Category::saved(function ($category) use ($pingIndexNow) {
            $pingIndexNow(route('categories.show', $category->slug));
        });

        Collection::saved(function ($collection) use ($pingIndexNow) {
            $pingIndexNow(route('collections.show', $collection->slug));
        });

        Occasion::saved(function ($occasion) use ($pingIndexNow) {
            $pingIndexNow(route('occasions.show', $occasion->slug));
        });

        Recipient::saved(function ($recipient) use ($pingIndexNow) {
            $pingIndexNow(route('recipients.show', $recipient->slug));
        });

        StaticPage::saved(function ($page) use ($pingIndexNow) {
            $pingIndexNow(route('pages.show', $page->slug));
        });
    }
}
