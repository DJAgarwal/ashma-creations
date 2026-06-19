<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = StaticPage::where('page_name', $slug)->firstOrFail();
        
        // Map slug to view path. If not found in pages directory, it might fail.
        // We assume views like pages.about, pages.contact exist.
        $viewPath = 'pages.' . $slug;
        
        if (!view()->exists($viewPath)) {
            // Check if it's in a subdirectory or has a different mapping if needed.
            // For now, follow the simple mapping.
            abort(404);
        }

        return view($viewPath, compact('page'));
    }
}
