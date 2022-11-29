<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PostTest extends TestCase
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

    public function test_show_post()
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

        $response = $this->get(route('post', $post->slug));

        $response->assertStatus(200);
    }

    public function test_create_post()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('posts.create'));

        $response->assertStatus(200);
    }

    public function test_store_post()
    {
        $data = [
            'title' => 'test title store',
            'content' => 'test store content',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false,
            'tag_ids' => [$this->post_tag->id]
        ];
        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->post(route('posts.store'), $data)
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_edit_post()
    {
        $data = Post::factory()->makeOne([
            'title' => 'test post edit post',
            'content' => 'test content edit post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false
        ]);
        $post_id = DB::table('posts')->insertGetId($data->toArray());

        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->withoutExceptionHandling()
            ->withViewErrors([])
            ->get(route('posts.edit', $post_id))
            ->assertStatus(200);
    }

    public function test_update_post()
    {
        $data = Post::factory()->makeOne([
            'title' => 'test post update post',
            'content' => 'test content update post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false,
        ]);
        $post_id = DB::table('posts')->insertGetId($data->toArray());

        $new_data = [
            'title' => ' new test post update post',
            'content' => 'new test content update post',
            'category_id' => $this->post_category->id,
            'tag_ids' => [$this->post_tag->id]
        ];

        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->patch(route('posts.update', $post_id), $new_data)
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_destroy_post()
    {
        $data = Post::factory()->makeOne([
            'title' => 'test post destroy post',
            'content' => 'test content destroy post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false,
        ]);
        $post_id = DB::table('posts')->insertGetId($data->toArray());

        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->delete(route('posts.destroy', $post_id))
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_force_delete_post()
    {
        $data = Post::factory()->makeOne([
            'title' => 'test post force_delete post',
            'content' => 'test content force_delete post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'is_hide' => false,
        ]);
        $post_id = DB::table('posts')->insertGetId($data->toArray());

        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->get(route('posts.force_delete', $post_id))
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_restore_post()
    {
        $data = Post::factory()->makeOne([
            'title' => 'test post restore post',
            'content' => 'test content restore post',
            'category_id' => $this->post_category->id,
            'user_id' => $this->user->id,
            'is_published' => true,
            'published_at' => now(),
            'deleted_at' => now(),
            'is_hide' => false,
        ]);
        $post_id = DB::table('posts')->insertGetId($data->toArray());

        $response = $this
            ->withoutMiddleware()
            ->actingAs($this->user)
            ->get(route('posts.restore', $post_id))
            ->assertStatus(302)
            ->assertSessionHas('success');
    }
}
