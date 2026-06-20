<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    /**
     * Show all top-level categories.
     */
    public function categoryIndex()
    {
        $page = StaticPage::where('page_name', 'categories')->first();
        $categories = Category::whereNull('parent_id')->get();

        return view('pages.categories.index', compact('page', 'categories'));
    }

    /**
     * Show products in a specific category.
     */
    public function categoryShow($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        // Use the category model as the 'page' provider for SEO fields
        $page = $category;
        
        // Get products from this category and its subcategories
        $categoryIds = $category->children->pluck('id')->push($category->id);
        $products = Product::whereIn('category_id', $categoryIds)->paginate(12);

        return view('pages.categories.show', compact('page', 'category', 'products'));
    }

    /**
     * Show a specific product.
     */
    public function productShow($slug)
    {
        $product = Product::where('slug', $slug)->with('category.parent')->firstOrFail();
        
        // Use the product model as the 'page' provider for SEO fields
        $page = $product;
        
        // Related products (from same category, excluding current)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('pages.products.show', compact('page', 'product', 'relatedProducts'));
    }
}
