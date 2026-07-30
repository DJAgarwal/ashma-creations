<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $staticPages = StaticPage::all();
        $categories = Category::active()->ordered()->get();
        $collections = \App\Models\Collection::active()->ordered()->get();
        $products = Product::latest()->get();

        $xml = view('static.sitemap', compact('staticPages', 'categories', 'collections', 'products'))->render();

        return Response::make($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
