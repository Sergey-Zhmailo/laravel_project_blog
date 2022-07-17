<?php

namespace Database\Factories;

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
        $title = fake()->sentence(rand(3, 8), true);
        $is_published = fake()->boolean(55);
        $created_at = fake()->dateTimeBetween('-3 months', '-2 days');

        return [
            'user_id' => rand(1, 11),
            'category_id' => rand(1, 11),
            'slug' => Str::slug($title),
            'title' => $title,
            'image' => fake()->imageUrl(640, 520, null, false, true, 'Faker'),
            'excerpt'=> fake()->text(rand(40, 100)),
            'content'=> fake()->realText(rand(1000, 4000)),
            'is_published' => $is_published,
            'is_hide' => fake()->boolean(15),
            'published_at' => $is_published ? fake()->dateTimeBetween('-2 months', '-1 days') : null,
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
