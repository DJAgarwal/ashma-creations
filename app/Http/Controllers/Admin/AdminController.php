<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Material;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\Style;
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
        $collectionsCount = Collection::count();
        $occasionsCount = Occasion::count();
        $recipientsCount = Recipient::count();
        $stylesCount = Style::count();
        $materialsCount = Material::count();

        return view('pages.admin.dashboard', compact(
            'categoriesCount',
            'productsCount',
            'collectionsCount',
            'occasionsCount',
            'recipientsCount',
            'stylesCount',
            'materialsCount'
        ));
    }
}
