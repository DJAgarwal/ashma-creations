<?php

namespace App\Models;

class Occasion extends SimpleTaxonomy
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
        return "Handcrafted Gifts & Bouquets for {$this->name} - Ashma Creations";
    }

    public function getMetaDescriptionAttribute(): string
    {
        return "Celebrate {$this->name} with unique everlasting handcrafted pipe cleaner bouquets, flower pots, and customized gifts by Ashma Creations.";
    }
}
