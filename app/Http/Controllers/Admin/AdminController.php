<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $categoriesCount = Category::count();
        $productsCount = Product::count();

        return view('pages.admin.dashboard', compact('categoriesCount', 'productsCount'));
    }
}
