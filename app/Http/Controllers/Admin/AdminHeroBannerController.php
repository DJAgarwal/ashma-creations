<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroBannerRequest;
use App\Models\Category;
use App\Models\Collection;
use App\Models\HeroBanner;
use App\Models\Occasion;
use App\Models\Product;
use App\Models\Recipient;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminHeroBannerController extends Controller
{
    use ImageOptimizationTrait;

    /**
     * Display a listing of the hero banners.
     */
    public function index(Request $request)
    {
        $query = HeroBanner::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('link_type', 'like', "%{$search}%")
                  ->orWhere('custom_url', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%");
            });
        }

        // Status / Trash filter
        $status = $request->input('status');
        if ($status === 'trashed') {
            $query->onlyTrashed();
        } elseif ($status === 'active') {
            $query->where('active', true);
        } elseif ($status === 'inactive') {
            $query->where('active', false);
        }

        $banners = $query->ordered()->paginate(15)->withQueryString();

        return view('pages.admin.hero_banners.index', compact('banners', 'status'));
    }

    /**
     * Show the form for creating a new hero banner.
     */
    public function create()
    {
        $destinations = $this->getDestinationEntities();

        return view('pages.admin.hero_banners.create', compact('destinations'));
    }

    /**
     * Store a newly created hero banner in storage.
     */
    public function store(HeroBannerRequest $request)
    {
        $desktopPath = null;
        if ($request->hasFile('desktop_image')) {
            $desktopPath = $this->uploadHeroBannerImage($request->file('desktop_image'), 'desktop');
        }

        $mobilePath = null;
        if ($request->hasFile('mobile_image')) {
            $mobilePath = $this->uploadHeroBannerImage($request->file('mobile_image'), 'mobile');
        }

        $linkType = $request->input('link_type');

        HeroBanner::create([
            'title' => 'Banner - ' . $linkType,
            'link_type' => $linkType,
            'link_id' => $request->input('link_id'),
            'custom_url' => $request->input('custom_url'),
            'desktop_image' => $desktopPath,
            'mobile_image' => $mobilePath,
            'active' => $request->boolean('active', true),
            'display_order' => (int) $request->input('display_order', 0),
        ]);

        return redirect()->route('admin.homepage.hero-banners.index')
            ->with('success', 'Banner created successfully!');
    }

    /**
     * Show the form for editing the specified hero banner.
     */
    public function edit($id)
    {
        $heroBanner = HeroBanner::withTrashed()->findOrFail($id);
        $destinations = $this->getDestinationEntities();

        return view('pages.admin.hero_banners.edit', compact('heroBanner', 'destinations'));
    }

    /**
     * Update the specified hero banner in storage.
     */
    public function update(HeroBannerRequest $request, $id)
    {
        $heroBanner = HeroBanner::withTrashed()->findOrFail($id);

        $desktopPath = $heroBanner->desktop_image;
        if ($request->hasFile('desktop_image')) {
            if (!empty($heroBanner->desktop_image) && File::exists(public_path($heroBanner->desktop_image))) {
                File::delete(public_path($heroBanner->desktop_image));
            }
            $desktopPath = $this->uploadHeroBannerImage($request->file('desktop_image'), 'desktop');
        }

        $mobilePath = $heroBanner->mobile_image;
        if ($request->hasFile('mobile_image')) {
            if (!empty($heroBanner->mobile_image) && File::exists(public_path($heroBanner->mobile_image))) {
                File::delete(public_path($heroBanner->mobile_image));
            }
            $mobilePath = $this->uploadHeroBannerImage($request->file('mobile_image'), 'mobile');
        } elseif ($request->boolean('remove_mobile_image')) {
            if (!empty($heroBanner->mobile_image) && File::exists(public_path($heroBanner->mobile_image))) {
                File::delete(public_path($heroBanner->mobile_image));
            }
            $mobilePath = null;
        }

        $linkType = $request->input('link_type');

        $heroBanner->update([
            'title' => 'Banner - ' . $linkType,
            'link_type' => $linkType,
            'link_id' => $request->input('link_id'),
            'custom_url' => $request->input('custom_url'),
            'desktop_image' => $desktopPath,
            'mobile_image' => $mobilePath,
            'active' => $request->boolean('active', true),
            'display_order' => (int) $request->input('display_order', 0),
        ]);

        return redirect()->route('admin.homepage.hero-banners.index')
            ->with('success', 'Banner updated successfully!');
    }

    /**
     * Remove (soft delete) the specified hero banner from storage.
     */
    public function destroy($id)
    {
        $heroBanner = HeroBanner::withTrashed()->findOrFail($id);

        if ($heroBanner->trashed()) {
            if (!empty($heroBanner->desktop_image) && File::exists(public_path($heroBanner->desktop_image))) {
                File::delete(public_path($heroBanner->desktop_image));
            }
            if (!empty($heroBanner->mobile_image) && File::exists(public_path($heroBanner->mobile_image))) {
                File::delete(public_path($heroBanner->mobile_image));
            }
            $heroBanner->forceDelete();

            return redirect()->route('admin.homepage.hero-banners.index')
                ->with('success', 'Banner permanently deleted!');
        }

        $heroBanner->delete();

        return redirect()->route('admin.homepage.hero-banners.index')
            ->with('success', 'Banner soft-deleted successfully!');
    }

    /**
     * Restore a soft-deleted hero banner.
     */
    public function restore($id)
    {
        $heroBanner = HeroBanner::onlyTrashed()->findOrFail($id);
        $heroBanner->restore();

        return redirect()->route('admin.homepage.hero-banners.index')
            ->with('success', 'Banner restored successfully!');
    }

    /**
     * Upload and optimize hero banner image into uploads/hero-banners/.
     */
    protected function uploadHeroBannerImage($file, string $type = 'desktop'): string
    {
        $destinationPath = public_path('uploads/hero-banners');
        $filename = time() . '_' . $type . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        if ($type === 'mobile') {
            return $this->saveOptimizedHeroBannerMobileImage($file, $destinationPath, $filename);
        }

        return $this->saveOptimizedHeroBannerDesktopImage($file, $destinationPath, $filename);
    }

    /**
     * Helper to fetch entities for dynamic target dropdowns.
     */
    protected function getDestinationEntities(): array
    {
        return [
            'categories' => Category::ordered()->get(['id', 'name', 'slug']),
            'collections' => Collection::ordered()->get(['id', 'name', 'slug']),
            'occasions' => Occasion::ordered()->get(['id', 'name', 'slug']),
            'recipients' => Recipient::ordered()->get(['id', 'name', 'slug']),
            'products' => Product::latest()->get(['id', 'name', 'slug']),
            'pages' => StaticPage::all(['id', 'page_name']),
        ];
    }
}
