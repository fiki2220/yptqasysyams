<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    public function test_santri_cannot_access_admin_panel(): void
    {
        $santri = User::factory()->create([
            'role' => 'student',
            'is_active' => true,
        ]);

        $this->actingAs($santri);

        $response = $this->get('/admin/meetings');
        $response->assertStatus(403);
    }
    
    public function test_ustad_can_access_admin_panel(): void
    {
        $ustad = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->actingAs($ustad);

        $response = $this->get('/admin/meetings');
        
        $response->assertStatus(200);
    }
}
