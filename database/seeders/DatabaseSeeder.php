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
        $this->call(StaticPageSeeder::class);

        // Create Admin User
        \App\Models\User::updateOrCreate(
            ['email' => 'dheerajagarwal1995@gmail.com'],
            [
                'name' => 'Dheeraj Agarwal',
                'password' => \Illuminate\Support\Facades\Hash::make('good best'),
            ]
        );

        // Parent Category
        $pipeCleaner = Category::updateOrCreate(
            ['slug' => 'pipe-cleaner'],
            [
                'name' => 'Pipe Cleaner',
                'description' => 'Beautiful handmade creations using premium pipe cleaners.',
                'meta_title' => 'Handmade Pipe Cleaner Crafts - Ashma Creations',
                'meta_description' => 'Explore our unique collection of handmade pipe cleaner crafts, from bouquets to custom decor.',
            ]
        );

        // Subcategories
        $bouquet = Category::updateOrCreate(
            ['slug' => 'bouquets'],
            [
                'name' => 'Bouquets',
                'description' => 'Stunning pipe cleaner bouquets for every occasion.',
                'parent_id' => $pipeCleaner->id,
                'meta_title' => 'Handmade Pipe Cleaner Bouquets - Ashma Creations',
                'meta_description' => 'Beautifully crafted pipe cleaner bouquets that last forever. Perfect for gifts and decor.',
            ]
        );

        $pots = Category::updateOrCreate(
            ['slug' => 'flower-pots'],
            [
                'name' => 'Flower Pots',
                'description' => 'Cute and colorful pipe cleaner flowers in decorative pots.',
                'parent_id' => $pipeCleaner->id,
                'meta_title' => 'Decorative Pipe Cleaner Flower Pots - Ashma Creations',
                'meta_description' => 'Miniature flower pots with handcrafted pipe cleaner flowers. Perfect for desks and small spaces.',
            ]
        );

        $individual = Category::updateOrCreate(
            ['slug' => 'individual-flowers'],
            [
                'name' => 'Individual Flowers',
                'description' => 'Single handcrafted flowers like Roses, Tulips, and Sunflowers.',
                'parent_id' => $pipeCleaner->id,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'custom-creations'],
            [
                'name' => 'Custom Creations',
                'description' => 'Personalized handmade gifts and decorations.',
            ]
        );

        // Products for Bouquets
        Product::updateOrCreate(
            ['slug' => 'elegant-rose-bouquet'],
            [
                'name' => 'Elegant Rose Bouquet',
                'description' => 'A beautiful bouquet of 12 handcrafted pipe cleaner roses in various shades of pink.',
                'details' => "Handmade with premium soft pipe cleaners.\nIncludes decorative wrapping and a ribbon.\nHeight: approx. 35cm.",
                'category_id' => $bouquet->id,
                'is_featured' => true,
                'meta_title' => 'Elegant Rose Bouquet - Handmade Pipe Cleaner Flowers',
                'meta_description' => 'Buy a beautiful 12-rose handcrafted pipe cleaner bouquet. A perfect everlasting gift.',
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'spring-tulip-bouquet'],
            [
                'name' => 'Spring Tulip Bouquet',
                'description' => 'Vibrant and cheerful tulips made from colorful pipe cleaners.',
                'details' => "Set of 7 colorful tulips.\nHand-twisted stems for a natural look.",
                'category_id' => $bouquet->id,
                'is_featured' => true,
            ]
        );

        // Products for Flower Pots
        Product::updateOrCreate(
            ['slug' => 'mini-sunflower-pot'],
            [
                'name' => 'Mini Sunflower Pot',
                'description' => 'A happy little sunflower in a ceramic mini pot.',
                'details' => "Perfect for office desks or bedside tables.\nHandcrafted with attention to detail.",
                'category_id' => $pots->id,
                'is_featured' => true,
            ]
        );

        Product::updateOrCreate(
            ['slug' => 'lavender-dream-pot'],
            [
                'name' => 'Lavender Dream Pot',
                'description' => 'Elegant pipe cleaner lavender sprigs in a rustic pot.',
                'details' => "Soothing colors, eternal beauty.\nNo maintenance required.",
                'category_id' => $pots->id,
            ]
        );

        // Products for Individual Flowers
        Product::updateOrCreate(
            ['slug' => 'single-red-rose'],
            [
                'name' => 'Single Red Rose',
                'description' => 'A classic red rose that never fades.',
                'details' => "Available in multiple colors upon request.",
                'category_id' => $individual->id,
            ]
        );
    }
}
