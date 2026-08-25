<?php

namespace App\Models;

use App\Models\Concerns\GeneratesUniqueSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use GeneratesUniqueSlug;
    use HasFactory;
    use SoftDeletes;
    use \App\Models\Concerns\FlushesHomeCache;

    protected $fillable = [
        'name',
        'slug',
        'price',
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
        'price' => 'decimal:2',
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

        return \App\Services\SchemaGenerator::forProduct($this);
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
