<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Show the home page with featured categories and products.
     */
    public function home()
    {
        $featuredCategories = Category::whereNull('parent_id')->take(4)->get();
        $featuredProducts = Product::where('is_featured', true)->take(4)->get();

        return view('pages.home', compact('featuredCategories', 'featuredProducts'));
    }

    /**
     * Show all top-level categories.
     */
    public function categoryIndex()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('pages.categories.index', compact('categories'));
    }

    /**
     * Show products in a specific category.
     */
    public function categoryShow($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Get products from this category and its subcategories
        $categoryIds = $category->children->pluck('id')->push($category->id);
        $products = Product::whereIn('category_id', $categoryIds)->paginate(12);

        return view('pages.categories.show', compact('category', 'products'));
    }

    /**
     * Show a specific product.
     */
    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        
        // Related products (from same category, excluding current)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('pages.products.show', compact('product', 'relatedProducts'));
    }
}
