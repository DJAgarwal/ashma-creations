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
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::with(['parent', 'children'])->get();
        return view('pages.admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $parentCategories = Category::all();
        return view('pages.admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'image' => ['nullable', 'image', 'max:5120'], // Max 5MB
        ]);

        $name = $request->input('name');
        
        // Generate Unique Slug
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Handle Image Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $imagePath = $this->saveOptimizedCategoryImage($file, $destinationPath, $filename);
        }

        // Auto-generate SEO meta values
        $description = $request->input('description') ?? '';
        $metaTitle = $name . ' - Ashma Creations';
        $metaDescription = Str::limit(
            !empty($description) 
                ? "Discover beautiful, handcrafted {$name} creations by Ashma Creations. " . strip_tags($description)
                : "Explore our handcrafted {$name} collection at Ashma Creations. Flowers, bouquets, and custom gifts made with love.",
            155,''
        );

        Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'parent_id' => $request->input('parent_id'),
            'image_path' => $imagePath,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'json_ld' => null, // Dynamic model accessor handles this automatically!
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully and SEO metadata generated!');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        // Exclude the category itself to prevent parenting loops
        $parentCategories = Category::where('id', '!=', $category->id)->get();
        return view('pages.admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:categories,id', 'different:id'],
            'image' => ['nullable', 'image', 'max:5120'], // Max 5MB (we compress to WebP)
        ]);

        $name = $request->input('name');

        // Check if name changed to regenerate slug
        $slug = $category->slug;
        if ($category->name !== $name) {
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $count = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        // Handle Image Upload
        $imagePath = $category->image_path;
        if ($request->hasFile('image')) {
            // Delete old image if it exists in uploads/
            if (!empty($category->image_path) && File::exists(public_path($category->image_path))) {
                File::delete(public_path($category->image_path));
            }

            $file = $request->file('image');
            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/categories');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $imagePath = $this->saveOptimizedCategoryImage($file, $destinationPath, $filename);
        }

        // Auto-generate/Update SEO values
        $description = $request->input('description') ?? '';
        $metaTitle = $name . ' - Ashma Creations';
        $metaDescription = Str::limit(
            !empty($description) 
                ? "Discover beautiful, handcrafted {$name} creations by Ashma Creations. " . strip_tags($description)
                : "Explore our handcrafted {$name} collection at Ashma Creations. Flowers, bouquets, and custom gifts made with love.",
            155,''
        );

        $category->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'parent_id' => $request->input('parent_id'),
            'image_path' => $imagePath,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully and SEO metadata refreshed!');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        // Delete image file if it exists
        if (!empty($category->image_path) && File::exists(public_path($category->image_path))) {
            File::delete(public_path($category->image_path));
        }

        // Delete database record (onDelete('cascade') handles subcategories and products relation cascade in DB)
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category and its descendants deleted successfully!');
    }
}
