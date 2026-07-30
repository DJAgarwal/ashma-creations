<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminCategoryController extends Controller
{
    use ImageOptimizationTrait;

    public function index(Request $request)
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('active'), fn ($query) => $query->where('active', $request->boolean('active')))
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('pages.admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::ordered()->get();

        return view('pages.admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:5120'],
            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $name = $request->input('name');
        $slug = Category::generateUniqueSlug($name);
        $description = $request->input('description') ?? '';

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadCategoryImage($request->file('image'));
        }

        Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'parent_id' => $request->input('parent_id'),
            'image_path' => $imagePath,
            'display_order' => (int) $request->input('display_order', 0),
            'active' => $request->boolean('active', true),
            'meta_title' => $request->input('seo_title') ?: ($name . ' - Ashma Creations'),
            'meta_description' => $request->input('seo_description') ?: Str::limit(
                !empty($description)
                    ? "Discover beautiful, handcrafted {$name} creations by Ashma Creations. " . strip_tags($description)
                    : "Explore our handcrafted {$name} collection at Ashma Creations.",
                155,
                ''
            ),
            'json_ld' => null,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        $parentCategories = Category::where('id', '!=', $category->id)->ordered()->get();

        return view('pages.admin.categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id', 'different:id'],
            'image' => ['nullable', 'image', 'max:5120'],
            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string'],
        ]);

        $name = $request->input('name');
        $slug = $category->slug;
        if ($category->name !== $name) {
            $slug = Category::generateUniqueSlug($name, $category->id);
        }

        $description = $request->input('description') ?? '';
        $imagePath = $category->image_path;

        if ($request->hasFile('image')) {
            if (!empty($category->image_path) && File::exists(public_path($category->image_path))) {
                File::delete(public_path($category->image_path));
            }
            $imagePath = $this->uploadCategoryImage($request->file('image'));
        }

        $category->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'parent_id' => $request->input('parent_id'),
            'image_path' => $imagePath,
            'display_order' => (int) $request->input('display_order', 0),
            'active' => $request->boolean('active', true),
            'meta_title' => $request->input('seo_title') ?: ($name . ' - Ashma Creations'),
            'meta_description' => $request->input('seo_description') ?: Str::limit(
                !empty($description)
                    ? "Discover beautiful, handcrafted {$name} creations by Ashma Creations. " . strip_tags($description)
                    : "Explore our handcrafted {$name} collection at Ashma Creations.",
                155,
                ''
            ),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if (!empty($category->image_path) && File::exists(public_path($category->image_path))) {
            File::delete(public_path($category->image_path));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    protected function uploadCategoryImage($file): string
    {
        $destinationPath = public_path('uploads/categories');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        return $this->saveOptimizedCategoryImage($file, $destinationPath, $filename);
    }
}
