<?php

namespace Tests\Unit;

use App\Services\AuthorService;
use App\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class AuthorUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $authorService;
    protected $authorRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->authorRepository = Mockery::mock(AuthorRepositoryInterface::class);
        $this->authorService = new AuthorService($this->authorRepository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_author()
    {
        $authorData = [
            'first_name' => 'Ahmed',
            'last_name' => 'Mohammed',
            'bio' => 'Ahmed Mohammed some biography',
            'email' => 'ahmed@email.com',
            'phone' => '1234567890',
        ];

        $this->authorRepository
            ->shouldReceive('create')
            ->once()
            ->with($authorData)
            ->andReturn(new Author($authorData));

        $createdAuthor = $this->authorService->create($authorData);

        $this->assertInstanceOf(Author::class, $createdAuthor);
        $this->assertEquals('Ahmed', $createdAuthor->first_name);
    }

    public function test_update_author()
    {
        $author = Author::factory()->create();
        $updatedData = [
            'first_name' => 'Musa',
            'last_name' => $author->last_name,
            'bio' => $author->bio,
            'email' => $author->email,
            'phone' => $author->phone,
        ];

        $this->authorRepository
            ->shouldReceive('update')
            ->once()
            ->with($updatedData, $author->id)
            ->andReturn(new Author($updatedData));

        $updatedAuthor = $this->authorService->update($updatedData, $author->id);

        $this->assertInstanceOf(Author::class, $updatedAuthor);
        $this->assertEquals('Musa', $updatedAuthor->first_name);
    }

    public function test_delete_author()
    {
        $author = Author::factory()->create();

        $this->authorRepository
            ->shouldReceive('delete')
            ->once()
            ->with($author->id)
            ->andReturn(true);

        $deleted = $this->authorService->delete($author->id);

        $this->assertTrue($deleted);
    }

    public function test_find_author()
    {
        $author = Author::factory()->create();

        $this->authorRepository
            ->shouldReceive('find')
            ->once()
            ->with($author->id)
            ->andReturn($author);

        $foundAuthor = $this->authorService->find($author->id);

        $this->assertInstanceOf(Author::class, $foundAuthor);
        $this->assertEquals($author->first_name, $foundAuthor->first_name);
    }

    public function test_all_authors()
    {
        $authors = Author::factory()->count(3)->create();

        $this->authorRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($authors);

        $allAuthors = $this->authorService->all();

        $this->assertCount(3, $allAuthors);
    }
}
