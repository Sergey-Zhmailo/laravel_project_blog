<?php

namespace Database\Factories;

use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(3, 8), true);
        $is_published = $this->faker->boolean(55);
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 days');

        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'category_id' => PostCategory::query()->inRandomOrder()->first()->id,
            'slug' => Str::slug($title),
            'title' => $title,
            'image' => 'no_image.png',
            'excerpt' => $this->faker->text(rand(40, 100)),
            'content' => $this->faker->realText(rand(1000, 4000)),
            'is_published' => $is_published,
            'is_hide' => $this->faker->boolean(15),
            'published_at' => $is_published ? $this->faker->dateTimeBetween('-2 months', '-1 days') : null,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
