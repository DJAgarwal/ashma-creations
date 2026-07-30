<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,CatalogController,PageController,SitemapController};
use App\Http\Controllers\Admin\{AdminAuthController,AdminController,AdminCategoryController,AdminCollectionController,AdminProductController,AdminTaxonomyController,};
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
        Route::get('/categories', 'categoryIndex')->name('categories.index');
        Route::get('/category/{slug}', 'categoryShow')->where('slug', '[a-z0-9\-]+')->name('categories.show');
        Route::get('/collection/{slug}', 'collectionShow')->where('slug', '[a-z0-9\-]+')->name('collections.show');
        Route::get('/product/{slug}', 'productShow')->where('slug', '[a-z0-9\-]+')->name('products.show');
    });
    Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('page.show');
});
