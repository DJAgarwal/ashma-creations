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

    protected $fillable = [
        'name',
        'slug',
        'active',
        'display_order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'display_order' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
