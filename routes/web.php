<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,CatalogController,PageController,SitemapController};
use App\Http\Controllers\Admin\{AdminAuthController,AdminController,AdminCategoryController};

// Sitemap & Robots
Route::controller(SitemapController::class)->group(function () {
    Route::get('/sitemap.xml', 'index')->name('sitemap');
    Route::get('/sitemap', fn () => redirect()->route('sitemap'));
});
Route::get('/robots.txt', function () {
    return response()->view('static.robots')->header('Content-Type', 'text/plain');
})->name('robots');
Route::get('/robots', fn () => redirect()->route('robots'));

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Guest Admin Routes
    Route::middleware('guest')->controller(AdminAuthController::class)->group(function () {
        Route::get('/login', 'showLogin')->name('login');
        Route::post('/login', 'login');
    });

    // Authenticated Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        
        // Categories CRUD Group
        Route::prefix('categories')->name('categories.')->controller(AdminCategoryController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('/{category}/edit', 'edit')->name('edit');
            Route::put('/{category}', 'update')->name('update');
            Route::delete('/{category}', 'destroy')->name('destroy');
        });
        
        // Logout Routes
        Route::controller(AdminAuthController::class)->group(function () {
            Route::post('/logout', 'logout')->name('logout');
            Route::get('/logout', 'logout'); // Convenience GET fallback
        });
    });
});

// Website Routes (with LogVisits middleware)
Route::middleware(\App\Http\Middleware\LogVisits::class)->group(function () {
    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/home', fn () => redirect()->route('home'));

    // Catalog Routes
    Route::controller(CatalogController::class)->group(function () {
        Route::get('/categories', 'categoryIndex')->name('categories.index');
        Route::get('/category/{slug}', 'categoryShow')->where('slug', '[a-z0-9\-]+')->name('categories.show');
        Route::get('/product/{slug}', 'productShow')->where('slug', '[a-z0-9\-]+')->name('products.show');
    });

    // Contact page
    Route::get('/contact', [PageController::class, 'show'])->defaults('slug', 'contact')->name('contact');

    // Static Pages (Catch-all for slugs like 'about', 'contact', 'privacy-policy')
    Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('page.show');
});
