<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class GoogleFeedController extends Controller
{
    /**
     * Generate and return Google Merchant Center Product Feed (RSS 2.0 XML).
     */
    public function index(Request $request)
    {
        // Allow manual cache purge via ?refresh=1 or ?nocache=1
        if ($request->has('refresh') || $request->has('nocache')) {
            Cache::forget('google_merchant_feed_xml');
        }

        // Cache XML for 1 hour (auto-invalidated on product save/delete via FlushesHomeCache)
        $xml = Cache::remember('google_merchant_feed_xml', 3600, function () {
            $products = Product::with([
                'primaryCategory.parent',
                'occasions',
                'recipients',
                'styles',
                'materials',
            ])
            ->whereNull('deleted_at')
            ->latest()
            ->get();

            return view('feeds.google-merchant', compact('products'))->render();
        });

        return Response::make($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'X-Robots-Tag' => 'noindex',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
