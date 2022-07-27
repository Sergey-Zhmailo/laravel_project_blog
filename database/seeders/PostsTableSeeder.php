<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 100; $i++) {
            $title = fake()->sentence(rand(3, 8), true);
            $is_published = fake()->boolean(55);
            $created_at = fake()->dateTimeBetween('-3 months', '-2 days');

            DB::table('posts')->insert([
                'user_id' => User::query()->inRandomOrder()->first()->id,
                'category_id' => PostCategory::query()->inRandomOrder()->first()->id,
                'slug' => Str::slug($title),
                'title' => $title,
                'image' => 'no_image.png',
                'excerpt' => fake()->text(rand(40, 100)),
                'content' => fake()->realText(rand(1000, 4000)),
                'is_published' => $is_published,
                'is_hide' => fake()->boolean(15),
                'published_at' => $is_published ? fake()->dateTimeBetween('-2 months', '-1 days') : null,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ]);
        }

    }
}
