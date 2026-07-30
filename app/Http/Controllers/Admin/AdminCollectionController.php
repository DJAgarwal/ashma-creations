<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminCollectionController extends Controller
{
    use ImageOptimizationTrait;

    public function index(Request $request)
    {
        $collections = Collection::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('active'), fn ($query) => $query->where('active', $request->boolean('active')))
            ->withCount('products')
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('pages.admin.collections.index', compact('collections'));
    }

    public function create()
    {
        return view('pages.admin.collections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'image', 'max:5120'],
            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $name = $request->input('name');
        $slug = Collection::generateUniqueSlug($name);
        $description = $request->input('description') ?? '';

        $bannerPath = null;
        if ($request->hasFile('banner_image')) {
            $bannerPath = $this->uploadBanner($request->file('banner_image'));
        }

        Collection::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'banner_image' => $bannerPath,
            'active' => $request->boolean('active', true),
            'display_order' => (int) $request->input('display_order', 0),
            'seo_title' => $request->input('seo_title') ?: ($name . ' - Ashma Creations'),
            'seo_description' => $request->input('seo_description') ?: Str::limit(
                !empty($description)
                    ? "Discover {$name} at Ashma Creations. " . strip_tags($description)
                    : "Shop our {$name} collection at Ashma Creations.",
                155,
                ''
            ),
        ]);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection created successfully!');
    }

    public function edit(Collection $collection)
    {
        return view('pages.admin.collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'image', 'max:5120'],
            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $name = $request->input('name');
        $slug = $collection->slug;
        if ($collection->name !== $name) {
            $slug = Collection::generateUniqueSlug($name, $collection->id);
        }

        $description = $request->input('description') ?? '';
        $bannerPath = $collection->banner_image;

        if ($request->hasFile('banner_image')) {
            $this->deleteBanner($collection->banner_image);
            $bannerPath = $this->uploadBanner($request->file('banner_image'));
        }

        $collection->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'banner_image' => $bannerPath,
            'active' => $request->boolean('active', true),
            'display_order' => (int) $request->input('display_order', 0),
            'seo_title' => $request->input('seo_title') ?: ($name . ' - Ashma Creations'),
            'seo_description' => $request->input('seo_description') ?: Str::limit(
                !empty($description)
                    ? "Discover {$name} at Ashma Creations. " . strip_tags($description)
                    : "Shop our {$name} collection at Ashma Creations.",
                155,
                ''
            ),
        ]);

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection updated successfully!');
    }

    public function destroy(Collection $collection)
    {
        $this->deleteBanner($collection->banner_image);
        $collection->delete();

        return redirect()->route('admin.collections.index')
            ->with('success', 'Collection deleted successfully!');
    }

    protected function uploadBanner($file): string
    {
        $destinationPath = public_path('uploads/collections');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        return $this->saveOptimizedImage($file, $destinationPath, $filename, 1600, 80);
    }

    protected function deleteBanner(?string $path): void
    {
        if (!empty($path) && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
