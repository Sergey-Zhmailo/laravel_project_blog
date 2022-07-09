<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title' => 'No category',
                'slug' => Str::slug('No category'),
            ],
            [
                'title' => 'Sport',
                'slug' => Str::slug('Sport'),
            ],
            [
                'title' => 'News',
                'slug' => Str::slug('News'),
            ],
            [
                'title' => 'Health',
                'slug' => Str::slug('Health'),
            ],
            [
                'title' => 'Politics',
                'slug' => Str::slug('Politics'),
            ],
            [
                'title' => 'Economics',
                'slug' => Str::slug('Economics'),
            ],
            [
                'title' => 'Ukrainian war',
                'slug' => Str::slug('Ukrainian war'),
            ],
            [
                'title' => 'Crypto',
                'slug' => Str::slug('Crypto'),
            ],
            [
                'title' => 'Digital',
                'slug' => Str::slug('Digital'),
            ],
            [
                'title' => 'E-commerce',
                'slug' => Str::slug('E-commerce'),
            ],
            [
                'title' => 'Podcast',
                'slug' => Str::slug('Podcast'),
            ],
        ];

        DB::table('post_categories')->insert($categories);
    }
}
