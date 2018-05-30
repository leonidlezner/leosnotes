<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Traits\CleanCookies;

class AdminLoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    use CleanCookies;

    
}
