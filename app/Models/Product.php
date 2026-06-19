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
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
