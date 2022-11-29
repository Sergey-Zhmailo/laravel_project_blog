<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostTag>
 */
class PostTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $title = $this->faker->word();
        $created_at = $this->faker->dateTimeBetween('-3 months', '-2 days');

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->word(),
            'created_at' => $created_at,
            'updated_at' => $created_at,
        ];
    }
}
