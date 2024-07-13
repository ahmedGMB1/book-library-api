<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\Interfaces\BookServiceInterface;
use App\Services\Interfaces\AuthorServiceInterface;

class BookController extends Controller
{
    protected $bookService;
    protected $authorService;

    public function __construct(BookServiceInterface $bookService, AuthorServiceInterface $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        try {
            $relations = ['author'];
            $perPage = $request->get('per_page', config('pagination.per_page_grid'));
            $books = $this->bookService->all($relations, $perPage);
            return BookResource::collection($books);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve books.'], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $criteria = $request->only(['title', 'publisher', 'isbn', 'year']);
            $relations = ['author'];
            $perPage = $request->get('per_page', config('pagination.per_page_grid'));
            $books = $this->bookService->search($criteria, $relations, $perPage);
            return BookResource::collection($books);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search books.'], 500);
        }
    }

    public function store(StoreBookRequest $request)
    {
        try {
            $book = $this->bookService->create($request->validated());
            return new BookResource($book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create book. '], 500);
        }
    }

    public function show($id)
    {
        try {
            $relations = ['author'];
            $book = $this->bookService->find($id, $relations);
            if (!$book) {
                return response()->json(['error' => 'Book not found.'], 404);
            }
            return new BookResource($book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve book.'], 500);
        }
    }

    public function update(UpdateBookRequest $request, $id)
    {
        try {
            $book = $this->bookService->update($request->validated(), $id);
            if (!$book) {
                return response()->json(['error' => 'Book not found.'], 404);
            }
            return new BookResource($book);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update book.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->bookService->delete($id);
            if (!$deleted) {
                return response()->json(['error' => 'Book not found.'], 404);
            }
            return response()->json(['message' => 'Book deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete book.'], 500);
        }
    }
}
