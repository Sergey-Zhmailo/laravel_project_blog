<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\User;
use Database\Factories\PostFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostCategoriesTableSeeder::class);
        $this->call(PostTagsTableSeeder::class);

        $this->call(UsersTableSeeder::class);
        User::factory(11)->create();
        $this->call(PostsTableSeeder::class);
//        Post::factory(100)->create();
        Comment::factory(20)->create();

        $this->call(PostPostTagsTableSeeder::class);
    }
}
