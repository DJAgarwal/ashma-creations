<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $page = StaticPage::where('page_name', 'home')->first();
        $featuredCategories = Category::whereNull('parent_id')->take(4)->get();
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();

        return view('pages.home', compact('page', 'featuredCategories', 'featuredProducts'));
    }
}
