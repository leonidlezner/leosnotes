<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Traits\UsersAdmins;
use Illuminate\Support\Facades\Hash;


/**
 * @group users
 */
class UsersTest extends TestCase
{
    use DatabaseMigrations;
    use UsersAdmins;
    
    public function test_guest_cannot_acess_users()
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->get(route('admin.users.show', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->get(route('admin.users.create'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
        
        $response = $this->get(route('admin.users.edit', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->post(route('admin.users.store'));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->put(route('admin.users.update', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response = $this->delete(route('admin.users.destroy', ['id' => 5]));
        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');
    }

    public function test_get_users_index()
    {
        $admin = $this->fetchAdmin();

        $response = $this->actingAs($admin, 'admin')->get(route('admin.users.index'));
        
        $response->assertStatus(200);
    }

    public function test_create_user()
    {
        $admin = $this->fetchAdmin();

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.users.create'));

        $response->assertStatus(200);
    }

    public function test_edit_user()
    {
        $admin = $this->fetchAdmin();
        $user = $this->fetchUser();

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.users.edit', ['id' => 5]));

        $response->assertStatus(404);

        $response = $this->actingAs($admin, 'admin')
                         ->get(route('admin.users.edit', ['id' => $user->id]));

        $response->assertStatus(200);
    }

    public function test_store_user()
    {
        $admin = $this->fetchAdmin();
        $faker = $this->fetchFaker();

        $new_mail = $faker->unique()->safeEmail;
        $new_password = str_random(10);
        $new_name = $faker->name;

        $response = $this->actingAs($admin, 'admin')
                         ->post(route('admin.users.store'), [
            'name' => $new_name,
            'email' => $new_mail,
            'password' => $new_password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = \App\User::where('email', $new_mail)->get()->first();

        $this->assertEquals($user->name, $new_name);       
        $this->assertEquals($user->email, $new_mail);
        $this->assertTrue(Hash::check($new_password, $user->password));           
    }


    public function test_store_user_no_password()
    {
        $admin = $this->fetchAdmin();
        $faker = $this->fetchFaker();

        $new_mail = $faker->unique()->safeEmail;
        $new_name = $faker->name;

        $response = $this->actingAs($admin, 'admin')
                         ->post(route('admin.users.store'), [
            'name' => $new_name,
            'email' => $new_mail
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');
    }


    public function test_update_user()
    {
        $admin = $this->fetchAdmin();
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $new_mail = $faker->unique()->safeEmail;
        $new_password = str_random(10);
        $new_name = $faker->name;

        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.users.update', ['id' => $user->id]), [
            'name' => $new_name,
            'email' => $new_mail,
            'password' => $new_password
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = $this->fetchUser($user->id);

        $this->assertEquals($user->name, $new_name);           
        $this->assertEquals($user->email, $new_mail);
        $this->assertTrue(Hash::check($new_password, $user->password));           
    }

    public function test_update_user_same_mail()
    {
        $admin = $this->fetchAdmin();
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $new_name = $faker->name;

        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.users.update', ['id' => $user->id]), [
            'name' => $new_name,
            'email' => $user->email
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = $this->fetchUser($user->id);

        $this->assertEquals($user->name, $new_name);
    }

    public function test_update_user_no_new_pass()
    {
        $admin = $this->fetchAdmin();
        $user = $this->fetchUser();
        $faker = $this->fetchFaker();

        $new_mail = $faker->unique()->safeEmail;
        $new_name = $faker->name;

        $old_password = $user->password;

        $response = $this->actingAs($admin, 'admin')
                         ->put(route('admin.users.update', ['id' => $user->id]), [
            'name' => $new_name,
            'email' => $new_mail
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success');

        $user = $this->fetchUser($user->id);

        $this->assertEquals($old_password, $user->password);           
    }
}
