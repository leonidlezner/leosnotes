<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\UsersAdmins;
use Illuminate\Support\Facades\Hash;


/**
 * @group profile
 */
class ProfileTest extends TestCase
{
    use DatabaseMigrations;
    use UsersAdmins;



    public function test_guest_cannot_acess_profile()
    {
        $response = $this->get(route('profile.index'));
        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $user = $this->fetchUser();
        $response = $this->get(route('profile.show', ['uuid' => $user->uuid]));
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function test_user_can_access_own_profile()
    {
        $user = $this->fetchUser();

        $response = $this->actingAs($user)->get(route('profile.index'));
        $response->assertStatus(200);
    }

    public function test_user_can_access_some_profile()
    {
        $user = $this->fetchUser();
        $userB = $this->fetchUser();

        $response = $this->actingAs($user)->get(route('profile.show', ['uuid' => $userB->uuid]));
        $response->assertStatus(200);
    }
}
