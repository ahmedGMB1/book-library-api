<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $authorIds = DB::table('authors')->pluck('id')->toArray();
        
        for ($i = 0; $i < 200; $i++) {
            DB::table('books')->insert([
                'title' => $faker->sentence,
                'isbn' => $faker->unique()->isbn13,
                'publisher' => $faker->company,
                'year' => $faker->year,
                'author_id' => $faker->randomElement($authorIds),
                'cover_image' => $faker->imageUrl(640, 480, 'books', true),
                'summary' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
