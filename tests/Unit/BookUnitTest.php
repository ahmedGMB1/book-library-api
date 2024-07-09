<?php

namespace Tests\Unit;

use App\Services\BookService;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Mockery;

class BookUnitTest extends TestCase
{
    use RefreshDatabase;

    protected $bookService;
    protected $bookRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = Mockery::mock(BookRepositoryInterface::class);
        $this->bookService = new BookService($this->bookRepository);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_book()
    {
        $author = Author::factory()->create();
        $bookData = [
            'title' => 'Sample Book',
            'author_id' => $author->id,
            'published_at' => now(),
        ];

        $this->bookRepository
            ->shouldReceive('create')
            ->once()
            ->with($bookData)
            ->andReturn(new Book($bookData));

        $createdBook = $this->bookService->create($bookData);

        $this->assertInstanceOf(Book::class, $createdBook);
        $this->assertEquals('Sample Book', $createdBook->title);
    }

    public function test_update_book()
    {
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id]);
        $updatedData = [
            'title' => 'Updated Book Title',
            'author_id' => $book->author_id,
            'published_at' => $book->published_at,
        ];

        $this->bookRepository
            ->shouldReceive('update')
            ->once()
            ->with($updatedData, $book->id)
            ->andReturn(new Book($updatedData));

        $updatedBook = $this->bookService->update($updatedData, $book->id);

        $this->assertInstanceOf(Book::class, $updatedBook);
        $this->assertEquals('Updated Book Title', $updatedBook->title);
    }

    public function test_delete_book()
    {
        $book = Book::factory()->create();

        $this->bookRepository
            ->shouldReceive('delete')
            ->once()
            ->with($book->id)
            ->andReturn(true);

        $deleted = $this->bookService->delete($book->id);

        $this->assertTrue($deleted);
    }

    public function test_find_book()
    {
        $book = Book::factory()->create();

        $this->bookRepository
            ->shouldReceive('find')
            ->once()
            ->with($book->id)
            ->andReturn($book);

        $foundBook = $this->bookService->find($book->id);

        $this->assertInstanceOf(Book::class, $foundBook);
        $this->assertEquals($book->title, $foundBook->title);
    }

    public function test_all_books()
    {
        $books = Book::factory()->count(3)->create();

        $this->bookRepository
            ->shouldReceive('all')
            ->once()
            ->andReturn($books);

        $allBooks = $this->bookService->all();

        $this->assertCount(3, $allBooks);
    }
}
