<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ArticleApiTest extends TestCase
{
    use ApiTestTrait;

    /**
     * @test
     */
    public function test_create_article()
    {
        Storage::fake('uploads');

        $file = UploadedFile::fake()->image('thumbnail.jpg');

        $article = factory(Article::class)->make();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'POST',
                '/api/articles',
                [
                    'name' => $article->name,
                    'content' => $article->content,
                    'created_by' => $article->created_by,
                    'category_id' => $article->category_id,
                    'thumbnail' => $file
                ]
            );

        $this->assertApiResponse($article->toArray());

        // Assert the file was stored...
        $test = Storage::disk('uploads')->assertExists('uploads/thumbnail/' . $file->hashName());

        // // Assert a file does not exist...
        // Storage::disk('uploads')->assertMissing('uploads/thumbnail/' . $file->hashName());
    }

    /**
     * @test
     */
    public function test_read_article()
    {
        $article = factory(Article::class)->create();

        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'GET',
                '/api/articles/'.$article->id
            );

        $this->assertApiResponse($article->toArray());
    }

    /**
     * @test
     */
    public function test_update_article()
    {
        $article = factory(Article::class)->create();
        $editedArticle = factory(Article::class)->make()->toArray();

        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'PUT',
                '/api/articles/'.$article->id,
                $editedArticle
            );

        $this->assertApiResponse($editedArticle);
    }

    /**
     * @test
     */
    public function test_delete_article()
    {
        $article = factory(Article::class)->create();
        $token = $this->getTokenByLogin();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])
            ->json(
                'DELETE',
                '/api/articles/'.$article->id
            );

        $this->assertApiSuccess();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])
            ->json(
                'GET',
                '/api/articles/'.$article->id
            );

        $this->response->assertStatus(404);
    }

    public function test_update_thumbnail()
    {
        Storage::fake('uploads');

        $file = UploadedFile::fake()->image('thumbnail.jpg');
        $article = factory(Article::class)->create();
        $this->response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->getTokenByLogin()
            ])
            ->json(
                'POST',
                '/api/articles/'.$article->id,
                [
                    '_method' => 'PUT',
                    'thumbnail' => $file
                ]
            );

        $this->assertApiSuccess();

        // Assert the file was stored...
        $test = Storage::disk('uploads')->assertExists('uploads/thumbnail/' . $file->hashName());
    }
}
