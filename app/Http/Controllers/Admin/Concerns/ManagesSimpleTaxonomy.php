<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Support\TaxonomyRegistry;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ManagesSimpleTaxonomy
{
    protected function taxonomyIndexQuery(string $type, Request $request)
    {
        $modelClass = TaxonomyRegistry::modelClass($type);

        return $modelClass::query()
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
    }

    protected function taxonomyValidationRules(string $type, ?object $item = null): array
    {
        $config = TaxonomyRegistry::get($type);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'active' => ['nullable', 'boolean'],
            'display_order' => ['nullable', 'integer', 'min:0'],
        ];

        if (!empty($config['fields']['icon'])) {
            $rules['icon'] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }

    protected function taxonomyAttributesFromRequest(string $type, Request $request, ?object $item = null): array
    {
        $config = TaxonomyRegistry::get($type);
        $name = $request->input('name');

        $slug = $item?->slug ?? TaxonomyRegistry::modelClass($type)::generateUniqueSlug($name);
        if ($item && $item->name !== $name) {
            $slug = TaxonomyRegistry::modelClass($type)::generateUniqueSlug($name, $item->id);
        }

        $attributes = [
            'name' => $name,
            'slug' => $slug,
            'active' => $request->boolean('active', true),
            'display_order' => (int) $request->input('display_order', 0),
        ];

        if (!empty($config['fields']['icon'])) {
            $attributes['icon'] = $request->input('icon');
        }

        return $attributes;
    }
}
