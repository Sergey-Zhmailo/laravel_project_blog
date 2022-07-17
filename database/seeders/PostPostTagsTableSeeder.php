<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostPostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 100; $i++) {
            $data[] = [
                'post_id' => rand(1, 100),
                'post_tag_id' => rand(1, 14),
            ];
        }

        DB::table('post_post_tags')->insert($data);
    }
}
