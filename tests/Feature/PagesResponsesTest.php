<?php

namespace Tests\Feature;

use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class PagesResponsesTest extends TestCase
{
    use DatabaseMigrations;

    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->seed();
    }

    public function test_response_homepage()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_response_category()
    {
        $response = $this->get(route('categories', PostCategory::find(1)->slug));

        $response->assertStatus(200);
    }

    public function test_response_tag()
    {
        $response = $this->get(route('tags', PostTag::find(1)->slug));

        $response->assertStatus(200);
    }

    public function test_response_login()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_response_logout()
    {
        $response = $this
            ->actingAs($this->user)
            ->followingRedirects()
            ->get(route('logout'));

        $response->assertStatus(200);
    }

    public function test_response_profile()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('profile'));

        $response->assertStatus(200);
    }

    public function test_response_user_posts()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('user_posts'));

        $response->assertStatus(200);
    }

    public function test_response_user_posts_trash()
    {
        $response = $this
            ->actingAs($this->user)
            ->get(route('user_posts_trash'));

        $response->assertStatus(200);
    }
}
