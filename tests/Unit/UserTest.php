<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function ___test_user_is_not_admin()
    {
        $user = factory(\App\User::class)->create();
        
        #$this->assertFalse($user->isAdmin());
    }

    public function ___test_user_can_be_admin()
    {
        $user = factory(\App\User::class)->create();

        

        #$this->assertTrue($user->isAdmin());
    }
}
