<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'details',
        'images',
        'category_id',
        'is_featured',
        'is_best_seller',
        'is_new_arrival',
        'is_trending',
        'meta_title',
        'meta_description',
        'json_ld',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'is_trending' => 'boolean',
        'json_ld' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
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
        ];

        $pos = 2;
        if ($this->primaryCategory) {
            if ($this->primaryCategory->parent) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => $pos++,
                    'name' => $this->primaryCategory->parent->name,
                    'item' => route('categories.show', $this->primaryCategory->parent->slug),
                ];
            }

            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $this->primaryCategory->name,
                'item' => route('categories.show', $this->primaryCategory->slug),
            ];
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $this->name,
            'item' => route('products.show', $this->slug),
        ];

        $images = [];
        if (!empty($this->images)) {
            foreach ($this->images as $img) {
                $images[] = filter_var($img, FILTER_VALIDATE_URL) ? $img : asset($img);
            }
        } else {
            $images[] = url('/images/logo.webp');
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Product',
                    '@id' => route('products.show', $this->slug),
                    'name' => $this->name,
                    'description' => $this->meta_description ?? ($this->description ?? 'Handcrafted ' . $this->name . ' by Ashma Creations.'),
                    'image' => $images,
                    'offers' => [
                        '@type' => 'Offer',
                        'url' => route('products.show', $this->slug),
                        'priceCurrency' => 'INR',
                        'price' => '0.00',
                        'availability' => 'https://schema.org/InStock',
                        'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
                    ],
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => 'Ashma Creations',
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs,
                ],
            ],
        ];
    }

    public function primaryCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /** @deprecated Use primaryCategory() — kept for backward compatibility */
    public function category(): BelongsTo
    {
        return $this->primaryCategory();
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_product')->withTimestamps();
    }

    public function occasions(): BelongsToMany
    {
        return $this->belongsToMany(Occasion::class, 'occasion_product')->withTimestamps();
    }

    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class, 'recipient_product')->withTimestamps();
    }

    public function styles(): BelongsToMany
    {
        return $this->belongsToMany(Style::class, 'style_product')->withTimestamps();
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'material_product')->withTimestamps();
    }
}
