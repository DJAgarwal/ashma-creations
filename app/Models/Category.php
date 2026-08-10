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

        return \App\Services\SchemaGenerator::forCategory($this);
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

    /**
     * Recursively retrieve all descendant category IDs (including self).
     */
    public function getAllDescendantCategoryIds(array &$visited = []): array
    {
        if (in_array($this->id, $visited)) {
            return [];
        }
        $visited[] = $this->id;

        $ids = [$this->id];
        $children = $this->relationLoaded('children') ? $this->children : $this->children()->get();
        foreach ($children as $child) {
            $ids = array_merge($ids, $child->getAllDescendantCategoryIds($visited));
        }

        return array_unique($ids);
    }

    /**
     * Accessor for products_count.
     * Includes products from subcategories if parent has subcategories.
     */
    public function getProductsCountAttribute(?int $value = null): int
    {
        $directCount = $value ?? (isset($this->attributes['products_count'])
            ? (int) $this->attributes['products_count']
            : null);

        if ($this->relationLoaded('children')) {
            $baseCount = $directCount ?? $this->products()->whereNull('deleted_at')->count();
            if ($this->children->isEmpty()) {
                return $baseCount;
            }

            $childrenCount = $this->children->sum(function ($child) {
                return $child->products_count;
            });

            return $baseCount + $childrenCount;
        }

        if ($directCount !== null && !$this->children()->exists()) {
            return $directCount;
        }

        $ids = $this->getAllDescendantCategoryIds();

        return Product::whereIn('category_id', $ids)->whereNull('deleted_at')->count();
    }
}
