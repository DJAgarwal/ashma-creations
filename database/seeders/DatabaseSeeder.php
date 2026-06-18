<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Parent Category
        $pipeCleaner = Category::create([
            'name' => 'Pipe Cleaner',
            'slug' => 'pipe-cleaner',
            'description' => 'Beautiful handmade creations using premium pipe cleaners.',
        ]);

        // Subcategories
        $bouquet = Category::create([
            'name' => 'Bouquets',
            'slug' => 'bouquets',
            'description' => 'Stunning pipe cleaner bouquets for every occasion.',
            'parent_id' => $pipeCleaner->id,
        ]);

        $pots = Category::create([
            'name' => 'Flower Pots',
            'slug' => 'flower-pots',
            'description' => 'Cute and colorful pipe cleaner flowers in decorative pots.',
            'parent_id' => $pipeCleaner->id,
        ]);

        $individual = Category::create([
            'name' => 'Individual Flowers',
            'slug' => 'individual-flowers',
            'description' => 'Single handcrafted flowers like Roses, Tulips, and Sunflowers.',
            'parent_id' => $pipeCleaner->id,
        ]);

        Category::create([
            'name' => 'Custom Creations',
            'slug' => 'custom-creations',
            'description' => 'Personalized handmade gifts and decorations.',
        ]);

        // Products for Bouquets
        Product::create([
            'name' => 'Elegant Rose Bouquet',
            'slug' => 'elegant-rose-bouquet',
            'description' => 'A beautiful bouquet of 12 handcrafted pipe cleaner roses in various shades of pink.',
            'details' => "Handmade with premium soft pipe cleaners.\nIncludes decorative wrapping and a ribbon.\nHeight: approx. 35cm.",
            'category_id' => $bouquet->id,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Spring Tulip Bouquet',
            'slug' => 'spring-tulip-bouquet',
            'description' => 'Vibrant and cheerful tulips made from colorful pipe cleaners.',
            'details' => "Set of 7 colorful tulips.\nHand-twisted stems for a natural look.",
            'category_id' => $bouquet->id,
            'is_featured' => true,
        ]);

        // Products for Flower Pots
        Product::create([
            'name' => 'Mini Sunflower Pot',
            'slug' => 'mini-sunflower-pot',
            'description' => 'A happy little sunflower in a ceramic mini pot.',
            'details' => "Perfect for office desks or bedside tables.\nHandcrafted with attention to detail.",
            'category_id' => $pots->id,
            'is_featured' => true,
        ]);

        Product::create([
            'name' => 'Lavender Dream Pot',
            'slug' => 'lavender-dream-pot',
            'description' => 'Elegant pipe cleaner lavender sprigs in a rustic pot.',
            'details' => "Soothing colors, eternal beauty.\nNo maintenance required.",
            'category_id' => $pots->id,
        ]);

        // Products for Individual Flowers
        Product::create([
            'name' => 'Single Red Rose',
            'slug' => 'single-red-rose',
            'description' => 'A classic red rose that never fades.',
            'details' => "Available in multiple colors upon request.",
            'category_id' => $individual->id,
        ]);
    }
}
