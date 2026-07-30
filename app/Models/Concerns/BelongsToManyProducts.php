<?php

namespace App\Models\Concerns;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyProducts
{
    public function products(): BelongsToMany
    {
        $pivotTable = \Illuminate\Support\Str::singular($this->getTable()) . '_product';
        return $this->belongsToMany(Product::class, $pivotTable)->withTimestamps();
    }
}
