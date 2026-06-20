<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCategoryCrudTest extends TestCase
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
     * Test that guests cannot access category CRUD pages.
     */
    public function test_guest_cannot_access_category_crud(): void
    {
        $this->get(route('admin.categories.index'))->assertRedirect('/admin/login');
        $this->get(route('admin.categories.create'))->assertRedirect('/admin/login');
        $this->post(route('admin.categories.store'))->assertRedirect('/admin/login');
    }

    /**
     * Test that admin can view categories listing page.
     */
    public function test_admin_can_view_categories_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Manage Categories');
        $response->assertSee('Create Category');
        $response->assertSee('Pipe Cleaner');
        $response->assertSee('Bouquets');
    }

    /**
     * Test creating a category automatically generates slug and SEO metadata.
     */
    public function test_admin_can_create_category_with_auto_generated_seo(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => 'Custom Handcrafted Flowers',
            'description' => 'A unique collection of custom handcrafted flowers made of premium soft pipe cleaners.',
            'parent_id' => null,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        // Check category exists in database with auto-generated values
        $category = Category::where('name', 'Custom Handcrafted Flowers')->firstOrFail();
        
        $this->assertEquals('custom-handcrafted-flowers', $category->slug);
        $this->assertEquals('Custom Handcrafted Flowers - Ashma Creations', $category->meta_title);
        $this->assertStringContainsString('A unique collection of custom handcrafted flowers', $category->meta_description);
        $this->assertNull($category->getRawOriginal('json_ld')); // Check raw DB column is null, accessor generates it dynamically
    }

    /**
     * Test that admin can edit a category.
     */
    public function test_admin_can_update_category_details(): void
    {
        $category = Category::where('slug', 'bouquets')->firstOrFail();

        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category->slug), [
            'name' => 'Super Bouquets',
            'description' => 'Updated bouquet collection.',
            'parent_id' => $category->parent_id,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $updatedCategory = Category::findOrFail($category->id);
        $this->assertEquals('Super Bouquets', $updatedCategory->name);
        $this->assertEquals('super-bouquets', $updatedCategory->slug);
        $this->assertEquals('Super Bouquets - Ashma Creations', $updatedCategory->meta_title);
    }

    /**
     * Test deleting a category.
     */
    public function test_admin_can_delete_category(): void
    {
        $category = Category::where('slug', 'flower-pots')->firstOrFail();

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category->slug));

        $response->assertRedirect(route('admin.categories.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }
}
