<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);
        return ['Authorization' => "Bearer $token"];
    }

    public function test_list_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books', $this->authenticate());

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_create_book()
    {
        $author = Author::factory()->create();

        $response = $this->postJson('/api/books', [
            'title' => 'New Book',
            'isbn' => '1234567890123',
            'publisher' => 'New Publisher',
            'year' => 2024,
            'summary' => 'This is a summary.',
            'author_id' => $author->id,
        ], $this->authenticate());

        $response->assertStatus(201)
                 ->assertJson([
                    'data' => [
                        'title' => 'New Book'
                    ]
                 ]);
    }

    public function test_show_book()
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}", $this->authenticate());

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'title' => $book->title
                    ]
                 ]);
    }

    public function test_update_book()
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Book',
            'isbn' => $book->isbn, 
            'publisher' => $book->publisher,
            'year' => $book->year,
            'summary' => $book->summary,
            'author_id' => $book->author_id,
        ], $this->authenticate());

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'title' => 'Updated Book'
                    ]
                 ]);
    }

    public function test_delete_book()
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}", [], $this->authenticate());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
