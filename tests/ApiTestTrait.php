<?php namespace Tests;

use App\Http\Resources\Users as UserResource;
use App\Models\User;

trait ApiTestTrait
{
    private $response;

    public function getTokenByLogin()
    {
        $user = factory(User::class)->create();
        $resLogin = $this->json(
            'POST',
            '/api/login',
            [
                'email' => $user->email,
                'password' => 'not4you'
            ]
        );

        return $resLogin['success']['token'];
    }

    public function assertApiResponse(Array $actualData)
    {
        $this->assertApiSuccess();

        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];

        $this->assertNotEmpty($responseData['id']);
        // $this->assertModelData($actualData, $responseData);
        $this->assertDataKeyValue($actualData, $responseData);
    }

    // public function assertApiResponse(Array $actualData, string $resource)
    // {
    //     $this->assertApiSuccess();

    //     $response = json_decode($this->response->getContent(), true);
    //     $responseData = $response['data'];

    //     $this->assertNotEmpty($responseData['id']);
    //     // $this->assertModelData($actualData, $responseData);
    //     $resourceClass = "App\\Http\\Resources\\$resource";
    //     $this->assertDataKeyValue($actualData, $responseData, $resourceClass);
    // }

    public function assertApiRes(Array $actualData, string $model) {
        $this->assertApiSuccess();

        $response = json_decode($this->response->getContent(), true);
        $responseData = $response['data'];
        $resourceClass = "App\\Http\\Resources\\$model";

        $this->assertDataWithResources($actualData, $responseData, $resourceClass);
    }

    public function assertApiSuccess()
    {
        $this->response->assertStatus(200);
        $this->response->assertJson(['success' => true]);
    }

    public function assertModelData(Array $actualData, Array $expectedData)
    {
        foreach ($actualData as $key => $value) {
            if (in_array($key, ['created_at', 'updated_at'])) {
                continue;
            }
            $this->assertEquals($actualData[$key], $expectedData[$key]);
        }
    }

    public function assertDataKeyValue(Array $actualData, Array $expectedData)
    {
        $checkKeys = ['created_at', 'updated_at'];
        foreach (array_keys(array_diff_key($actualData, $expectedData)) as $key) {
            array_push($checkKeys, $key);
        }
        foreach ($actualData as $key => $value) {
            if (in_array($key, $checkKeys)) {
                continue;
            }
            $this->assertEquals($actualData[$key], $expectedData[$key]);
        }
    }

    // public function assertDataWithResources(Array $actualData, Array $expectedData, string $resourceClass)
    // {
    //     $firstData = new $resourceClass($actualData);
    //     $secondData = new $resourceClass($expectedData);
    //     dd($firstData, $secondData);
    //     foreach ($actualData as $key => $value) {
    //         if (in_array($key, ['created_at', 'updated_at'])) {
    //             continue;
    //         }
    //         $this->assertEquals($actualData[$key], $expectedData[$key]);
    //     }
    // }

}
