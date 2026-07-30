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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AdminProductController extends Controller
{
    use ImageOptimizationTrait;

    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['primaryCategory.parent', 'collections', 'occasions', 'recipients'])
            ->withCount('collections')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->input('category_id')))
            ->when($request->filled('collection_id'), function ($query) use ($request) {
                $query->whereHas('collections', fn ($q) => $q->where('collections.id', $request->input('collection_id')));
            })
            ->when($request->filled('occasion_id'), function ($query) use ($request) {
                $query->whereHas('occasions', fn ($q) => $q->where('occasions.id', $request->input('occasion_id')));
            })
            ->when($request->filled('recipient_id'), function ($query) use ($request) {
                $query->whereHas('recipients', fn ($q) => $q->where('recipients.id', $request->input('recipient_id')));
            })
            ->when($request->filled('style_id'), function ($query) use ($request) {
                $query->whereHas('styles', fn ($q) => $q->where('styles.id', $request->input('style_id')));
            })
            ->when($request->filled('material_id'), function ($query) use ($request) {
                $query->whereHas('materials', fn ($q) => $q->where('materials.id', $request->input('material_id')));
            })
            ->when($request->boolean('is_featured'), fn ($query) => $query->where('is_featured', true))
            ->when($request->boolean('is_best_seller'), fn ($query) => $query->where('is_best_seller', true))
            ->when($request->boolean('is_new_arrival'), fn ($query) => $query->where('is_new_arrival', true))
            ->when($request->boolean('is_trending'), fn ($query) => $query->where('is_trending', true))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('pages.admin.products.index', [
            'products' => $products,
            'categories' => Category::active()->ordered()->get(),
            'collections' => Collection::active()->ordered()->get(),
            'occasions' => Occasion::active()->ordered()->get(),
            'recipients' => Recipient::active()->ordered()->get(),
            'styles' => Style::active()->ordered()->get(),
            'materials' => Material::active()->ordered()->get(),
            'filters' => $request->only([
                'search', 'category_id', 'collection_id', 'occasion_id',
                'recipient_id', 'style_id', 'material_id',
                'is_featured', 'is_best_seller', 'is_new_arrival', 'is_trending',
            ]),
        ]);
    }

    public function create()
    {
        return view('pages.admin.products.create', $this->taxonomyFormData());
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        $name = $request->input('name');
        $slug = Product::query()->where('slug', Str::slug($name))->exists()
            ? $this->generateUniqueProductSlug($name)
            : Str::slug($name);

        $uploadedImages = $this->handleImageUploads($request, []);

        $product = Product::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $request->input('description'),
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
            'images' => $uploadedImages,
            'is_featured' => $request->boolean('is_featured'),
            'is_best_seller' => $request->boolean('is_best_seller'),
            'is_new_arrival' => $request->boolean('is_new_arrival'),
            'is_trending' => $request->boolean('is_trending'),
            'meta_title' => $name . ' - Ashma Creations',
            'meta_description' => $this->buildMetaDescription($name, $request->input('description')),
            'json_ld' => null,
        ]);

        $this->syncTaxonomies($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        $product->load(['collections', 'occasions', 'recipients', 'styles', 'materials']);

        return view('pages.admin.products.edit', array_merge(
            ['product' => $product],
            $this->taxonomyFormData()
        ));
    }

    public function update(Request $request, Product $product)
    {
        $this->validateProduct($request);

        $name = $request->input('name');
        $slug = $product->slug;
        if ($product->name !== $name) {
            $slug = $this->generateUniqueProductSlug($name, $product->id);
        }

        $uploadedImages = $this->handleImageUploads($request, $product->images ?? []);

        $product->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $request->input('description'),
            'details' => $request->input('details'),
            'category_id' => $request->input('category_id'),
            'images' => $uploadedImages,
            'is_featured' => $request->boolean('is_featured'),
            'is_best_seller' => $request->boolean('is_best_seller'),
            'is_new_arrival' => $request->boolean('is_new_arrival'),
            'is_trending' => $request->boolean('is_trending'),
            'meta_title' => $name . ' - Ashma Creations',
            'meta_description' => $this->buildMetaDescription($name, $request->input('description')),
        ]);

        $this->syncTaxonomies($product, $request);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
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

    protected function taxonomyFormData(): array
    {
        return [
            'categories' => Category::active()->ordered()->with('parent')->get(),
            'collections' => Collection::active()->ordered()->get(),
            'occasions' => Occasion::active()->ordered()->get(),
            'recipients' => Recipient::active()->ordered()->get(),
            'styles' => Style::active()->ordered()->get(),
            'materials' => Material::active()->ordered()->get(),
        ];
    }

    protected function validateProduct(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'collection_ids' => ['nullable', 'array'],
            'collection_ids.*' => ['exists:collections,id'],
            'occasion_ids' => ['nullable', 'array'],
            'occasion_ids.*' => ['exists:occasions,id'],
            'recipient_ids' => ['nullable', 'array'],
            'recipient_ids.*' => ['exists:recipients,id'],
            'style_ids' => ['nullable', 'array'],
            'style_ids.*' => ['exists:styles,id'],
            'material_ids' => ['nullable', 'array'],
            'material_ids.*' => ['exists:materials,id'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
            'is_featured' => ['nullable', 'boolean'],
            'is_best_seller' => ['nullable', 'boolean'],
            'is_new_arrival' => ['nullable', 'boolean'],
            'is_trending' => ['nullable', 'boolean'],
        ]);
    }

    protected function syncTaxonomies(Product $product, Request $request): void
    {
        $product->collections()->sync($request->input('collection_ids', []));
        $product->occasions()->sync($request->input('occasion_ids', []));
        $product->recipients()->sync($request->input('recipient_ids', []));
        $product->styles()->sync($request->input('style_ids', []));
        $product->materials()->sync($request->input('material_ids', []));
    }

    protected function generateUniqueProductSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    protected function buildMetaDescription(string $name, ?string $description): string
    {
        return Str::limit(
            !empty($description)
                ? "Explore {$name} at Ashma Creations. Handcrafted creations made with care. " . strip_tags($description)
                : "Handcrafted {$name} by Ashma Creations. Browse our beautiful custom collections.",
            155,
            ''
        );
    }

    protected function handleImageUploads(Request $request, array $existingImages): array
    {
        if (!$request->hasFile('images')) {
            return $existingImages;
        }

        foreach ($existingImages as $oldImage) {
            if (File::exists(public_path($oldImage))) {
                File::delete(public_path($oldImage));
            }
        }

        $uploadedImages = [];
        $destinationPath = public_path('uploads/products');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        foreach ($request->file('images') as $file) {
            $filenameBase = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $uploadedImages[] = $this->saveOptimizedProductImage($file, $destinationPath, $filenameBase);
        }

        return $uploadedImages;
    }
}
