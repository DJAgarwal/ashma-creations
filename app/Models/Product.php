<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'details',
        'images',
        'category_id',
        'is_featured',
        'meta_title',
        'meta_description',
        'json_ld',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'json_ld' => 'array',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the dynamic JSON-LD schema if not explicitly set.
     */
    public function getJsonLdAttribute($value)
    {
        $decoded = is_string($value) ? json_decode($value, true) : $value;
        if (!empty($decoded)) {
            return $decoded;
        }

        // Generate dynamic JSON-LD for product page
        $breadcrumbs = [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/')
            ]
        ];

        $pos = 2;
        if ($this->category) {
            if ($this->category->parent) {
                $breadcrumbs[] = [
                    '@type' => 'ListItem',
                    'position' => $pos++,
                    'name' => $this->category->parent->name,
                    'item' => route('categories.show', $this->category->parent->slug)
                ];
            }
            
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $pos++,
                'name' => $this->category->name,
                'item' => route('categories.show', $this->category->slug)
            ];
        }

        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => $pos,
            'name' => $this->name,
            'item' => route('products.show', $this->slug)
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
                        'price' => '0.00', // Default/placeholder since price is not tracked in DB
                        'availability' => 'https://schema.org/InStock',
                        'priceValidUntil' => date('Y-12-31', strtotime('+1 year'))
                    ],
                    'brand' => [
                        '@type' => 'Brand',
                        'name' => 'Ashma Creations'
                    ]
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => $breadcrumbs
                ]
            ]
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
