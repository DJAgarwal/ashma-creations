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
        return \App\Services\SchemaGenerator::forCollection($this);
    }
}
