<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);
        return ['Authorization' => "Bearer $token"];
    }

    public function test_list_authors()
    {
        Author::factory()->count(3)->create();

        $response = $this->getJson('/api/authors', $this->authenticate());

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_create_author()
    {
        $response = $this->postJson('/api/authors', [
            'first_name' => 'New',
            'last_name' => 'Author',
            'email' => 'newauthor@example.com',
            'phone' => '123-456-7890',
        ], $this->authenticate());

        $response->assertStatus(201)
                 ->assertJson([
                    'data' => [
                        'firstName' => 'New',
                        'lastName' => 'Author',
                        'email' => 'newauthor@example.com',
                        'phone' => '123-456-7890',
                    ]
                 ]);
    }

    public function test_show_author()
    {
        $author = Author::factory()->create();

        $response = $this->getJson("/api/authors/{$author->id}", $this->authenticate());

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'firstName' => $author->first_name,
                        'lastName' => $author->last_name,
                        'email' => $author->email,
                        'phone' => $author->phone,
                    ]
                 ]);
    }

    public function test_update_author()
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/authors/{$author->id}", [
            'first_name' => 'Updated',
            'last_name' => 'Author',
            'email' => $author->email,  
            'phone' => $author->phone,  
        ], $this->authenticate());

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'firstName' => 'Updated',
                        'lastName' => 'Author'
                    ]
                 ]);
    }

    public function test_delete_author()
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/authors/{$author->id}", [], $this->authenticate());

        $response->assertStatus(200);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
