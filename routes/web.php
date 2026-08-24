<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,CatalogController,PageController,SitemapController};
use App\Http\Controllers\Admin\{AdminAuthController,AdminController,AdminCategoryController,AdminCollectionController,AdminHeroBannerController,AdminProductController,AdminTaxonomyController,};
use App\Support\TaxonomyRegistry;

// Sitemap & Robots
Route::controller(SitemapController::class)->group(function () {
    Route::get('/sitemap.xml', 'index')->name('sitemap');
    Route::get('/sitemap', fn () => redirect()->route('sitemap'));
});
Route::get('/robots.txt', function () {
    return response()->view('static.robots')->header('Content-Type', 'text/plain');
})->name('robots');
Route::get('/robots', fn () => redirect()->route('robots'));

// IndexNow Verification Key File
Route::get('/8f3c67d804d74cc989691be23221c1e4.txt', function () {
    return response('8f3c67d804d74cc989691be23221c1e4', 200, ['Content-Type' => 'text/plain; charset=utf-8']);
});


Route::prefix('admin')->name('admin.')->group(function () {
    
    Route::middleware('guest')->controller(AdminAuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
    });
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::prefix('categories')->name('categories.')->controller(AdminCategoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::put('/{category}', 'update')->name('update');
            Route::delete('/{category}', 'destroy')->name('destroy');
        });
        Route::prefix('collections')->name('collections.')->controller(AdminCollectionController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{collection}/edit', 'edit')->name('edit');
            Route::put('/{collection}', 'update')->name('update');
            Route::delete('/{collection}', 'destroy')->name('destroy');
        });

        Route::prefix('taxonomies/{type}')
            ->whereIn('type', TaxonomyRegistry::keys())
            ->name('taxonomies.')
            ->controller(AdminTaxonomyController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{slug}/edit', 'edit')->name('edit');
                Route::put('/{slug}', 'update')->name('update');
                Route::delete('/{slug}', 'destroy')->name('destroy');
            });

        Route::prefix('products')->name('products.')->controller(AdminProductController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{product}/edit', 'edit')->name('edit');
            Route::put('/{product}', 'update')->name('update');
            Route::delete('/{product}', 'destroy')->name('destroy');
        });

        Route::prefix('homepage')->name('homepage.')->group(function () {
            Route::prefix('hero-banners')->name('hero-banners.')->controller(AdminHeroBannerController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/', 'store')->name('store');
                Route::get('/{id}/edit', 'edit')->name('edit');
                Route::put('/{id}', 'update')->name('update');
                Route::delete('/{id}', 'destroy')->name('destroy');
                Route::post('/{id}/restore', 'restore')->name('restore');
            });
        });
        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('/logout', 'logout')->name('logout');
            Route::get('/logout', 'logout');
        });
    });
});
Route::middleware(\App\Http\Middleware\LogVisits::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', fn () => redirect()->route('home'));

    Route::controller(CatalogController::class)->group(function () {
        // Main Shop Catalog
        Route::get('/products', 'productIndex')->name('products.index');
        Route::get('/shop', fn () => redirect()->route('products.index'));

        // Categories Taxonomy
        Route::get('/categories', 'categoryIndex')->name('categories.index');
        Route::get('/category/{slug}', 'categoryShow')->where('slug', '[a-z0-9\-]+')->name('categories.show');

        // Collections Taxonomy
        Route::get('/collections', 'collectionIndex')->name('collections.index');
        Route::get('/collection/{slug}', 'collectionShow')->where('slug', '[a-z0-9\-]+')->name('collections.show');
        Route::get('/collections/{slug}', fn ($slug) => redirect()->route('collections.show', $slug));

        // Occasions Taxonomy
        Route::get('/occasions', 'occasionIndex')->name('occasions.index');
        Route::get('/occasion/{slug}', 'occasionShow')->where('slug', '[a-z0-9\-]+')->name('occasions.show');
        Route::get('/occasions/{slug}', fn ($slug) => redirect()->route('occasions.show', $slug));

        // Recipients Taxonomy
        Route::get('/recipients', 'recipientIndex')->name('recipients.index');
        Route::get('/recipient/{slug}', 'recipientShow')->where('slug', '[a-z0-9\-]+')->name('recipients.show');
        Route::get('/recipients/{slug}', fn ($slug) => redirect()->route('recipients.show', $slug));

        // Styles & Materials Landing Pages
        Route::get('/style/{slug}', 'styleShow')->where('slug', '[a-z0-9\-]+')->name('styles.show');
        Route::get('/styles/{slug}', fn ($slug) => redirect()->route('styles.show', $slug));
        Route::get('/material/{slug}', 'materialShow')->where('slug', '[a-z0-9\-]+')->name('materials.show');
        Route::get('/materials/{slug}', fn ($slug) => redirect()->route('materials.show', $slug));

        // Single Product Canonical Page
        Route::get('/product/{slug}', 'productShow')->where('slug', '[a-z0-9\-]+')->name('products.show');

        // Global Search
        Route::get('/search', 'search')->name('search');
    });

    // Static Pages fallback
    Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('page.show');
});
