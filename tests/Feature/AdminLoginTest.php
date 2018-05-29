<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AdminLoginTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guest_can_not_login()
    {
        $response = $this->get('/admin');
        
        $response->assertStatus(302);

        $response->assertRedirect('/login');
    }
    
    public function test_user_can_not_use_dashboard()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)->get('/admin');

        $response->assertStatus(403);
    }

    public function _test_admin_can_login()
    {
        
    }
}
