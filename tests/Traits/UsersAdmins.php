<?php

namespace Tests\Traits;

use Faker\Factory as Faker;

trait UsersAdmins
{
    private function fetchAdmin()
    {
        return factory(\App\Admin::class)->create();
    }

    private function fetchUser($id = null)
    {
        if($id == null)
        {
            return factory(\App\User::class)->create();
        }
        else
        {
            return \App\User::find($id);
        }
    }

    private function fetchFaker()
    {
        return Faker::create();
    }
}