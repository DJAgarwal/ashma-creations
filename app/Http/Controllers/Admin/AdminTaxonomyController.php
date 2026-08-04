<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSimpleTaxonomy;
use App\Http\Controllers\Controller;
use App\Support\TaxonomyRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminTaxonomyController extends Controller
{
    use ManagesSimpleTaxonomy;
    use ImageOptimizationTrait;

    public function index(Request $request, string $type)
    {
        $config = TaxonomyRegistry::get($type);
        $items = $this->taxonomyIndexQuery($type, $request);

        return view('pages.admin.taxonomies.index', [
            'type' => $type,
            'config' => $config,
            'items' => $items,
        ]);
    }

    public function create(string $type)
    {
        return view('pages.admin.taxonomies.create', [
            'type' => $type,
            'config' => TaxonomyRegistry::get($type),
        ]);
    }

    public function store(Request $request, string $type)
    {
        $request->validate($this->taxonomyValidationRules($type));

        $attributes = $this->taxonomyAttributesFromRequest($type, $request);

        if (!empty(TaxonomyRegistry::get($type)['fields']['image']) && $request->hasFile('image')) {
            $destinationPath = public_path("uploads/{$type}");
            $attributes['image_path'] = $this->saveOptimizedImage(
                $request->file('image'),
                $destinationPath,
                $request->input('name'),
                1000,
                85
            );
        }

        $modelClass = TaxonomyRegistry::modelClass($type);
        $modelClass::create($attributes);

        return redirect()
            ->route('admin.taxonomies.index', $type)
            ->with('success', TaxonomyRegistry::labelSingular($type) . ' created successfully!');
    }

    public function edit(string $type, string $slug)
    {
        $item = TaxonomyRegistry::resolve($type, $slug);

        return view('pages.admin.taxonomies.edit', [
            'type' => $type,
            'config' => TaxonomyRegistry::get($type),
            'item' => $item,
        ]);
    }

    public function update(Request $request, string $type, string $slug)
    {
        $item = TaxonomyRegistry::resolve($type, $slug);
        $request->validate($this->taxonomyValidationRules($type, $item));

        $attributes = $this->taxonomyAttributesFromRequest($type, $request, $item);

        if (!empty(TaxonomyRegistry::get($type)['fields']['image']) && $request->hasFile('image')) {
            if (!empty($item->image_path) && File::exists(public_path($item->image_path))) {
                File::delete(public_path($item->image_path));
            }
            $destinationPath = public_path("uploads/{$type}");
            $attributes['image_path'] = $this->saveOptimizedImage(
                $request->file('image'),
                $destinationPath,
                $request->input('name'),
                1000,
                85
            );
        }

        $item->update($attributes);

        return redirect()
            ->route('admin.taxonomies.index', $type)
            ->with('success', TaxonomyRegistry::labelSingular($type) . ' updated successfully!');
    }

    public function destroy(string $type, string $slug)
    {
        $item = TaxonomyRegistry::resolve($type, $slug);

        if (!empty($item->image_path) && File::exists(public_path($item->image_path))) {
            File::delete(public_path($item->image_path));
        }

        $item->delete();

        return redirect()
            ->route('admin.taxonomies.index', $type)
            ->with('success', TaxonomyRegistry::labelSingular($type) . ' deleted successfully!');
    }
}
