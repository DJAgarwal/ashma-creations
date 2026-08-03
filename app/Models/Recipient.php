<?php

namespace App\Models;

class Recipient extends SimpleTaxonomy
{
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image_path',
        'active',
        'display_order',
    ];
}
