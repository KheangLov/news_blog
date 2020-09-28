<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User;

class AuthApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_user_login()
    {
        $user = factory(User::class)->create();
        $this->response = $this->json(
            'POST',
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'not4you'
            ]
        );
        $this->assertApiSuccess();
    }
}
