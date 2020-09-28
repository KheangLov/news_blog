<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_register()
    // {
    //     $user = factory(User::class)->make();
    //     $res = $this->post('/admin/register', [
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'password' => 'not4you',
    //         'password_confirmation' => 'not4you'
    //     ]);
    // }

    // public function test_success_login()
    // {
    //     $user = factory(User::class)->make();
    //     $res = $this->post('/admin/login', [
    //         '_token' => csrf_token(),
    //         'email' => $user->email,
    //         'password' => 'password'
    //     ]);
    // }

    // public function test_user_receives_an_email_with_a_password_reset_link()
    // {
    //     Notification::fake();

    //     $user = factory(User::class)->create();

    //     $response = $this->post('/password/email', [
    //         'email' => $user->email,
    //     ]);

    //     // assertions go here
    //     $token = DB::table('password_resets')->first();
    //     $this->assertNotNull($token);
    // }


}
