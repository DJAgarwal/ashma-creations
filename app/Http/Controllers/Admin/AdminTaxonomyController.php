<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSimpleTaxonomy;
use App\Http\Controllers\Controller;
use App\Support\TaxonomyRegistry;
use Illuminate\Http\Request;

class AdminTaxonomyController extends Controller
{
    use ManagesSimpleTaxonomy;

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

        $modelClass = TaxonomyRegistry::modelClass($type);
        $modelClass::create($this->taxonomyAttributesFromRequest($type, $request));

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

        $item->update($this->taxonomyAttributesFromRequest($type, $request, $item));

        return redirect()
            ->route('admin.taxonomies.index', $type)
            ->with('success', TaxonomyRegistry::labelSingular($type) . ' updated successfully!');
    }

    public function destroy(string $type, string $slug)
    {
        $item = TaxonomyRegistry::resolve($type, $slug);
        $item->delete();

        return redirect()
            ->route('admin.taxonomies.index', $type)
            ->with('success', TaxonomyRegistry::labelSingular($type) . ' deleted successfully!');
    }
}
