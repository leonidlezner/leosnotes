<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\UsersAdmins;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;

/**
 * @group user
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;
    use UsersAdmins;

    public function test_generate_uuid()
    {
        $faker = $this->fetchFaker();
        $user = new \App\User();

        $this->assertEquals(0, strlen($user->uuid));

        $user->name = $faker->name;
        $user->email = $faker->email;
        $user->password = Hash::make('secret');

        $user->save();

        $uuid = $user->uuid;

        $this->assertEquals(36, strlen($user->uuid));

        $user->name = $faker->name;

        $user->save();

        $this->assertEquals($uuid, $user->uuid);

        $u = \App\User::withUuid($uuid)->get()->first();

        $this->assertEquals($user->id, $u->id);
    }
}
