<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpmbRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
    
    public function test_registration_page_returns_a_successful_response(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }
}
