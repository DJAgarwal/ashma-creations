<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('email', 'dheerajagarwal1995@gmail.com')->firstOrFail();
    }

    /**
     * Test that guests cannot access product CRUD pages.
     */
    public function test_guest_cannot_access_product_crud(): void
    {
        $this->get(route('admin.products.index'))->assertRedirect('/admin/login');
        $this->get(route('admin.products.create'))->assertRedirect('/admin/login');
        $this->post(route('admin.products.store'))->assertRedirect('/admin/login');
    }

    /**
     * Test that admin can view products listing page.
     */
    public function test_admin_can_view_products_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.products.index'));

        $response->assertStatus(200);
        $response->assertSee('Manage Products');
        $response->assertSee('Create Product');
        $response->assertSee('Elegant Rose Bouquet');
        $response->assertSee('Spring Tulip Bouquet');
    }

    /**
     * Test creating a product automatically generates slug and SEO metadata.
     */
    public function test_admin_can_create_product_with_auto_generated_seo(): void
    {
        $category = Category::where('slug', 'bouquets')->firstOrFail();

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Premium Carnation Pot',
            'description' => 'Beautiful premium handmade carnations in a ceramic pot.',
            'details' => "100% handcrafted\nIdeal gift for Mother's Day",
            'category_id' => $category->id,
            'is_featured' => 1,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        // Check product exists in database with auto-generated values
        $product = Product::where('name', 'Premium Carnation Pot')->firstOrFail();
        
        $this->assertEquals('premium-carnation-pot', $product->slug);
        $this->assertEquals('Premium Carnation Pot - Ashma Creations', $product->meta_title);
        $this->assertStringContainsString('Explore Premium Carnation Pot at Ashma Creations', $product->meta_description);
        $this->assertTrue($product->is_featured);
        $this->assertNull($product->getRawOriginal('json_ld')); // Dynamic schema accessor handles this dynamically
    }

    /**
     * Test that admin can edit a product.
     */
    public function test_admin_can_update_product_details(): void
    {
        $product = Product::where('slug', 'spring-tulip-bouquet')->firstOrFail();
        $category = Category::where('slug', 'flower-pots')->firstOrFail();

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product->slug), [
            'name' => 'Updated Spring Tulip Bouquet',
            'description' => 'Updated description.',
            'details' => 'New details.',
            'category_id' => $category->id,
            'is_featured' => 0,
        ]);

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $updatedProduct = Product::findOrFail($product->id);
        $this->assertEquals('Updated Spring Tulip Bouquet', $updatedProduct->name);
        $this->assertEquals('updated-spring-tulip-bouquet', $updatedProduct->slug);
        $this->assertEquals($category->id, $updatedProduct->category_id);
        $this->assertFalse($updatedProduct->is_featured);
    }

    /**
     * Test deleting a product.
     */
    public function test_admin_can_delete_product(): void
    {
        $product = Product::where('slug', 'elegant-rose-bouquet')->firstOrFail();

        $response = $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product->slug));

        $response->assertRedirect(route('admin.products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
