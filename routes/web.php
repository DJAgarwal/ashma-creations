<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController, CatalogController, PageController, SitemapController};

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', fn () => redirect()->route('home'));

// Sitemap & Robots
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap', fn () => redirect()->route('sitemap'));
Route::get('/robots.txt', function () {
    return response()->view('static.robots')->header('Content-Type', 'text/plain');
})->name('robots');
Route::get('/robots', fn () => redirect()->route('robots'));

// Catalog
Route::get('/categories', [CatalogController::class, 'categoryIndex'])->name('categories.index');
Route::get('/category/{slug}', [CatalogController::class, 'categoryShow'])->where('slug', '[a-z0-9\-]+')->name('categories.show');
Route::get('/product/{slug}', [CatalogController::class, 'productShow'])->where('slug', '[a-z0-9\-]+')->name('products.show');

// Admin Panel Routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [App\Http\Controllers\AdminAuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/logout', [App\Http\Controllers\AdminAuthController::class, 'logout']); // Convenience GET fallback
});

// Contact page
Route::get('/contact', [PageController::class, 'show'])->defaults('slug', 'contact')->name('contact');

// Static Pages (Catch-all for slugs like 'about', 'contact', 'privacy-policy')
Route::get('/{slug}', [PageController::class, 'show'])->where('slug', '[a-z0-9\-]+')->name('page.show');
