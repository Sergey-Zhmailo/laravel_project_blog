<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'title' => 'Football',
                'slug' => Str::slug('Football'),
            ],
            [
                'title' => 'Basketball',
                'slug' => Str::slug('Basketball'),
            ],
            [
                'title' => 'Ukraine',
                'slug' => Str::slug('Ukraine'),
            ],
            [
                'title' => 'Hot',
                'slug' => Str::slug('Hot'),
            ],
            [
                'title' => 'Weapons',
                'slug' => Str::slug('Weapons'),
            ],
            [
                'title' => 'WTO',
                'slug' => Str::slug('WTO'),
            ],
            [
                'title' => 'Army',
                'slug' => Str::slug('Army'),
            ],
            [
                'title' => 'Bitcoin',
                'slug' => Str::slug('Bitcoin'),
            ],
            [
                'title' => 'Mobile',
                'slug' => Str::slug('Mobile'),
            ],
            [
                'title' => 'Apple',
                'slug' => Str::slug('Apple'),
            ],
            [
                'title' => 'Windows',
                'slug' => Str::slug('Windows'),
            ],
            [
                'title' => 'HP',
                'slug' => Str::slug('HP'),
            ],
            [
                'title' => 'Asus',
                'slug' => Str::slug('Asus'),
            ],
            [
                'title' => 'Dell',
                'slug' => Str::slug('Dell'),
            ],
        ];

        DB::table('post_tags')->insert($tags);
    }
}
