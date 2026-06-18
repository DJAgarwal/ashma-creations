<?php

use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'home'])->name('home');
Route::get('/categories', [CatalogController::class, 'categoryIndex'])->name('categories.index');
Route::get('/category/{slug}', [CatalogController::class, 'categoryShow'])->name('categories.show');
Route::get('/product/{slug}', [CatalogController::class, 'productShow'])->name('products.show');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
