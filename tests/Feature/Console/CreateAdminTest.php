<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;

class CreateAdminTest extends TestCase
{
    use DatabaseMigrations;
    
    /**
     * @group console
     *
     */
    public function test_check_create_admin()
    {
        /*
        Artisan::call('admin:create', [
            'name' => 'value1',
            'email' => 'value2',
        ]);
*/
        
    }
}
