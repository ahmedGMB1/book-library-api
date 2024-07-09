<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'isbn' => $this->faker->isbn13,
            'publisher' => $this->faker->company,
            'year' => $this->faker->year,
            'summary' => $this->faker->paragraph,
            'author_id' => Author::factory(), 
        ];
    }
}
