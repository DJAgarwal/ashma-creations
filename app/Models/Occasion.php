<?php

namespace App\Models;

class Occasion extends SimpleTaxonomy
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'active',
        'display_order',
    ];
}
