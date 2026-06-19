<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_terms_and_conditions_page_loads_and_has_json_ld(): void
    {
        $response = $this->get('/terms-and-conditions');

        $response->assertStatus(200);
        $response->assertSee('application/ld+json');
        $response->assertSee('Terms and Conditions of Ashma Creations');
    }

    public function test_privacy_policy_page_loads(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
    }

    public function test_disclaimer_page_loads(): void
    {
        $response = $this->get('/disclaimer');

        $response->assertStatus(200);
        $response->assertSee('Disclaimer');
    }
}
