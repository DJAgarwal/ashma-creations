<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    use ImageOptimizationTrait;
    /**
     * Display a listing of products.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('pages.admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'], // Max 5MB per image
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $name = $request->input('name');

        // Generate Unique Slug
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Handle Images Upload
        $uploadedImages = [];
        if ($request->hasFile('images')) {
            $destinationPath = public_path('uploads/products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $originalFilename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $filenameBase = $originalFilename;
                $uploadedImages[] = $this->saveOptimizedProductImage($file, $destinationPath, $filenameBase);
            }
        }

        // Auto-generate SEO meta values
        $description = $request->input('description') ?? '';
        $metaTitle = $name . ' - Ashma Creations';
        $metaDescription = Str::limit(
            !empty($description) 
                ? "Explore {$name} at Ashma Creations. Handcrafted flower creations made with care. " . strip_tags($description)
                : "Handcrafted {$name} by Ashma Creations. Browse our beautiful custom collections.",
            155
        );

        Product::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
            'images' => $uploadedImages,
            'is_featured' => $request->boolean('is_featured'),
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'json_ld' => null, // Managed dynamically by dynamic accessor on model
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully and SEO metadata generated!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $name = $request->input('name');

        // Check if name changed to regenerate slug
        $slug = $product->slug;
        if ($product->name !== $name) {
            $slug = Str::slug($name);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        // Handle Images Upload
        $uploadedImages = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images from storage
            if (!empty($product->images)) {
                foreach ($product->images as $oldImage) {
                    if (File::exists(public_path($oldImage))) {
                        File::delete(public_path($oldImage));
                    }
                }
            }

            $uploadedImages = [];
            $destinationPath = public_path('uploads/products');
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $file) {
                $originalFilename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $filenameBase = $originalFilename;
                $uploadedImages[] = $this->saveOptimizedProductImage($file, $destinationPath, $filenameBase);
            }
        }

        // Auto-generate/Update SEO values
        $description = $request->input('description') ?? '';
        $metaTitle = $name . ' - Ashma Creations';
        $metaDescription = Str::limit(
            !empty($description) 
                ? "Explore {$name} at Ashma Creations. Handcrafted flower creations made with care. " . strip_tags($description)
                : "Handcrafted {$name} by Ashma Creations. Browse our beautiful custom collections.",
            155
        );

        $product->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
            'images' => $uploadedImages,
            'is_featured' => $request->boolean('is_featured'),
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully and SEO metadata refreshed!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete all associated images
        if (!empty($product->images)) {
            foreach ($product->images as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }
}
