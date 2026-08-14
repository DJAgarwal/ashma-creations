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

    public function getMetaTitleAttribute(): string
    {
        return "Handcrafted Gifts & Products for {$this->name} - Ashma Creations";
    }

    public function getMetaDescriptionAttribute(): string
    {
        return "Explore our curated collection of handcrafted pipe cleaner flowers, bouquets, and personalized gifts for {$this->name}. Unique everlasting handmade crafts by Ashma Creations.";
    }
}
