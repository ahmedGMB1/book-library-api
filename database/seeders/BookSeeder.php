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
                'title' => $faker->words(3, true),
                'isbn' => $faker->unique()->isbn13,
                'publisher' => $faker->company,
                'year' => $faker->year,
                'author_id' => $faker->randomElement($authorIds),
                'cover_image' => $faker->randomElement([
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f5004c967a25c8b5620c99c/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f4e13b167a25c8b5620c7d8/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f513024a4b58bc8b2e21026/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f02b7af7b9841e1454c23cf/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f02cd8a7b9841e1454c23e2/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/5f02cb987b9841e1454c23e0/screenshot.png',
                    'https://assets.dochipo.com/media/companies/dochipo/templates/628b77802caeb8210f7e1d1c/screenshot.png',
                ]),
                'summary' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
