<?php

namespace Tests\Traits;

trait UsersAdmins
{
    private function fetchAdmin()
    {
        return factory(\App\Admin::class)->create();
    }
}