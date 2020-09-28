<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User;

class UserApiTest extends TestCase
{
    use ApiTestTrait;

    /**
     * @test
     */

    public function test_list_users()
    {
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'GET',
                '/api/users'
            );

        $this->assertApiSuccess();
    }

    public function test_create_user()
    {
        $user = factory(User::class)->make()->toArray();

        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'POST',
                '/api/users', $user
            );
        $this->assertApiResponse($user);
        // $this->assertModelData($this->response->original['data'], $user);
        // $this->assertDataKeyValue($this->response->original['data'], $user);
    }

    /**
     * @test
     */
    public function test_read_user()
    {
        $user = factory(User::class)->create();

        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'GET',
                '/api/users/'.$user->id
            );
        $this->assertApiResponse($user->toArray());
        // $this->assertDataKeyValue($this->response->original['data'], $user->toArray());
    }

    /**
     * @test
     */
    public function test_update_user()
    {
        $user = factory(User::class)->create();
        $editedUser = factory(User::class)->make()->toArray();

        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'PUT',
                '/api/users/'.$user->id,
                $editedUser
            );

        $this->assertApiResponse($editedUser);
    }

    /**
     * @test
     */
    public function test_delete_user()
    {
        $user = factory(User::class)->create();
        $token = $this->getTokenByLogin();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])
            ->json(
                'DELETE',
                '/api/users/'.$user->id
            );

        $this->assertApiSuccess();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])
            ->json(
                'GET',
                '/api/users/'.$user->id
            );

        $this->response->assertStatus(404);
    }
}
