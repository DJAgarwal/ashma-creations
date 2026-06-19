<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    /**
     * Test that guests accessing /admin are redirected to the admin login page.
     */
    public function test_guest_is_redirected_to_admin_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /**
     * Test that the admin login page loads successfully.
     */
    public function test_admin_login_page_loads(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
        $response->assertSee('Sign In');
    }

    /**
     * Test login with invalid credentials.
     */
    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'dheerajagarwal1995@gmail.com',
            'password' => 'wrong password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Test login with correct credentials.
     */
    public function test_admin_login_succeeds_with_valid_credentials(): void
    {
        // The user is already seeded via $seed = true in DatabaseSeeder
        $response = $this->post('/admin/login', [
            'email' => 'dheerajagarwal1995@gmail.com',
            'password' => 'good best',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticated();
    }

    /**
     * Test authenticated admin can see the dashboard stats.
     */
    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = User::where('email', 'dheerajagarwal1995@gmail.com')->firstOrFail();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Welcome back, Admin!');
        $response->assertSee('Categories');
        $response->assertSee('Products');
    }

    /**
     * Test logout.
     */
    public function test_admin_logout(): void
    {
        $admin = User::where('email', 'dheerajagarwal1995@gmail.com')->firstOrFail();

        $response = $this->actingAs($admin)->post('/admin/logout');

        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }
}
