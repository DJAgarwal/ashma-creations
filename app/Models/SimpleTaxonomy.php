<?php

namespace App\Models;

use App\Models\Concerns\BelongsToManyProducts;
use App\Models\Concerns\GeneratesUniqueSlug;
use App\Models\Concerns\HasActiveOrdering;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SimpleTaxonomy extends Model
{
    use BelongsToManyProducts;
    use GeneratesUniqueSlug;
    use HasActiveOrdering;
    use HasFactory;
    use SoftDeletes;
    use \App\Models\Concerns\FlushesHomeCache;

    protected $fillable = [
        'name',
        'slug',
        'active',
        'display_order',
        'image_path',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function getMetaTitleAttribute(): string
    {
        return "{$this->name} Handcrafted Gifts & Products - Ashma Creations";
    }

    public function getMetaDescriptionAttribute(): string
    {
        return "Explore our curated collection of handcrafted pipe cleaner flowers, bouquets, and gifts for {$this->name}. Unique everlasting handmade crafts by Ashma Creations.";
    }

    public function getJsonLdAttribute()
    {
        $type = strtolower(class_basename(static::class));
        $pluralType = \Illuminate\Support\Str::plural($type);
        $showRoute = \Illuminate\Support\Facades\Route::has("{$pluralType}.show") ? route("{$pluralType}.show", $this->slug) : url("/{$type}/{$this->slug}");
        $indexRoute = \Illuminate\Support\Facades\Route::has("{$pluralType}.index") ? route("{$pluralType}.index") : url('/');

        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
        ];

        if (\Illuminate\Support\Facades\Route::has("{$pluralType}.index")) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => ucfirst($pluralType),
                'item' => $indexRoute,
            ];
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $this->name,
                'item' => $showRoute,
            ];
        } else {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $this->name,
                'item' => $showRoute,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $showRoute,
                    'url' => $showRoute,
                    'name' => $this->meta_title,
                    'description' => $this->meta_description,
                    'inLanguage' => 'en',
                    'mainEntityOfPage' => $showRoute,
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs,
                ],
            ],
        ];
    }
}
