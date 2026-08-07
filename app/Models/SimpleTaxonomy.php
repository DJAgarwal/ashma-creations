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
        return \App\Services\SchemaGenerator::forTaxonomy($this);
    }
}
