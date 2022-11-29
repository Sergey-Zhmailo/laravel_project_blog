<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use WithFaker;

    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->createOne();
        $this->post_category = PostCategory::factory()->create();
        $this->post_tag = PostTag::factory()->create();
    }

    public function test_response_search()
    {
        $response = $this->get(route('search'));

        $response->assertStatus(200);
    }

    public function test_search_post()
    {
        $post = Post::factory()->makeOne([
            'title' => 'test post show post',
            'content' => 'test content show post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false
        ]);
        DB::table('posts')->insert($post->toArray());

        $response = $this->withoutMiddleware()
            ->withoutExceptionHandling()
            ->withViewErrors([])
            ->post('search', [
                'search_text' => 'test'
            ]);

        $response->assertStatus(200);
    }
}
