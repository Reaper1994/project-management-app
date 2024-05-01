<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    // Refresh the database before each test

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response_for_authorized_users(): void
    {
// Create an authorized user
        $user = User::factory()->create();

// Simulate authentication by logging in the user
        $this->actingAs($user);

// Make the request
        $response = $this->get('/dashboard');

// Assert that the response status is 200 (OK) for authorized users
        $response->assertStatus(200);
    }

    /**
     * A test to ensure unauthorized users are redirected.
     */
    public function test_the_application_redirects_unauthorized_users(): void
    {
// Make the request without authenticating the user
        $response = $this->get('/');

// Assert that the response status is 302 (Redirect) for unauthorized users
        $response->assertStatus(302);
    }
}
