<?php

namespace App\Models;

use App\Models\Concerns\BelongsToManyProducts;
use App\Models\Concerns\GeneratesUniqueSlug;
use App\Models\Concerns\HasActiveOrdering;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
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
        'description',
        'banner_image',
        'active',
        'display_order',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getMetaTitleAttribute(): ?string
    {
        return $this->seo_title;
    }

    public function getMetaDescriptionAttribute(): ?string
    {
        return $this->seo_description;
    }

    public function getJsonLdAttribute()
    {
        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => $this->name,
                'item' => route('collections.show', $this->slug),
            ],
        ];

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => route('collections.show', $this->slug),
                    'url' => route('collections.show', $this->slug),
                    'name' => $this->seo_title ?? ($this->name . ' - Ashma Creations'),
                    'description' => $this->seo_description ?? ($this->description ?? 'Explore our ' . $this->name . ' collection at Ashma Creations.'),
                    'inLanguage' => 'en',
                    'mainEntityOfPage' => route('collections.show', $this->slug),
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs,
                ],
            ],
        ];
    }
}
