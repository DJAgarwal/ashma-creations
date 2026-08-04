<?php

namespace App\Models;

use App\Models\Concerns\GeneratesUniqueSlug;
use App\Models\Concerns\HasActiveOrdering;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use GeneratesUniqueSlug;
    use HasActiveOrdering;
    use HasFactory;
    use SoftDeletes;
    use \App\Models\Concerns\FlushesHomeCache;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image_path',
        'display_order',
        'active',
        'meta_title',
        'meta_description',
        'json_ld',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
        'json_ld' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSeoTitleAttribute(): ?string
    {
        return $this->meta_title;
    }

    public function getSeoDescriptionAttribute(): ?string
    {
        return $this->meta_description;
    }

    public function getJsonLdAttribute($value)
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;
        if (!empty($decoded)) {
            return $decoded;
        }

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
                'name' => 'Categories',
                'item' => route('categories.index'),
            ],
        ];

        $pos = 3;
        if ($this->parent) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $this->parent->name,
                'item' => route('categories.show', $this->parent->slug),
            ];
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $this->name,
            'item' => route('categories.show', $this->slug),
        ];

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => route('categories.show', $this->slug),
                    'url' => route('categories.show', $this->slug),
                    'name' => $this->meta_title ?? ($this->name . ' - Ashma Creations'),
                    'description' => $this->meta_description ?? ($this->description ?? 'Explore our complete collection of ' . $this->name . ' at Ashma Creations.'),
                    'inLanguage' => 'en',
                    'mainEntityOfPage' => route('categories.show', $this->slug),
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs,
                ],
            ],
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
