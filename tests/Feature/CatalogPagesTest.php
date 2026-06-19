<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogPagesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test that the categories listing page loads, has HTML breadcrumbs, and correct JSON-LD.
     */
    public function test_categories_index_page_loads_and_has_breadcrumbs_and_seo(): void
    {
        $response = $this->get('/categories');

        $response->assertStatus(200);
        // Visual breadcrumb assertion
        $response->assertSee('Home');
        $response->assertSee('Categories');
        
        // JSON-LD assertion
        $response->assertSee('application/ld+json');
        $response->assertSee('Product Categories - Ashma Creations');
    }

    /**
     * Test that an individual category page loads, has correct visual breadcrumbs, and JSON-LD.
     */
    public function test_category_show_page_loads_and_has_breadcrumbs_and_seo(): void
    {
        $category = Category::where('slug', 'bouquets')->firstOrFail();

        $response = $this->get('/category/' . $category->slug);

        $response->assertStatus(200);
        
        // Visual breadcrumb assertion
        $response->assertSee('Home');
        $response->assertSee('Categories');
        $response->assertSee($category->name);
        
        // Dynamic JSON-LD assertion
        $response->assertSee('application/ld+json');
        $response->assertSee('CollectionPage');
        $response->assertSee($category->name);
    }

    /**
     * Test that an individual product page loads, has correct visual breadcrumbs, and JSON-LD.
     */
    public function test_product_show_page_loads_and_has_breadcrumbs_and_seo(): void
    {
        $product = Product::where('slug', 'elegant-rose-bouquet')->firstOrFail();

        $response = $this->get('/product/' . $product->slug);

        $response->assertStatus(200);
        
        // Visual breadcrumb assertion
        $response->assertSee('Home');
        $response->assertSee($product->category->name);
        $response->assertSee($product->name);
        
        // Dynamic JSON-LD assertion
        $response->assertSee('application/ld+json');
        $response->assertSee('Product');
        $response->assertSee($product->name);
    }
}
