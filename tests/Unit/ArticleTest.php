<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    // public function test_articles_tbl_has_expected_columns()
    // {
    //     $this->assertTrue(
    //       Schema::hasColumns('articles', [
    //         'id','name', 'thumbnail', 'content'
    //     ]), 1);
    // }

    // public function test_a_type_has_many_articles()
    // {
    //     // $user    = factory(User::class)->create();
    //     $category = factory(Category::class)->create();
    //     $article = factory(Article::class)->create([
    //         'category_id' => $category->id,
    //         'created_by' => 1
    //     ]);

    //     // Method 1: A comment exists in a post's comment collections.
    //     $this->assertTrue($category->article->contains($article));
    //     // $this->assertTrue($user->article->contains($article));

    //     // Method 2: Count that a post comments collection exists.
    //     // $this->assertEquals(1, $category->article->count());

    //     // Method 3: Comments are related to posts and is a collection instance.
    //     // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $category->article);
    //     // $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->article);
    // }
}
