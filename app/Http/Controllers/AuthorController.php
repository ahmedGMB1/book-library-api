<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Services\Interfaces\AuthorServiceInterface;

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorServiceInterface $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        try {
            $relations = ['books'];
            $perPage = $request->get('per_page', config('pagination.per_page'));
            $authors = $this->authorService->all($relations, $perPage);
            return AuthorResource::collection($authors);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve authors.'], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $criteria = $request->only(['email', 'phone', 'author_name']);
            $relations = ['books'];
            $perPage = $request->get('per_page', config('pagination.per_page'));
            $authors = $this->authorService->search($criteria, $relations, $perPage);
            return AuthorResource::collection($authors);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to search authors.'], 500);
        }
    }

    public function store(StoreAuthorRequest $request)
    {
        try {
            $author = $this->authorService->create($request->validated());
            return new AuthorResource($author);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create author.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $relations = ['books'];
            $author = $this->authorService->find($id, $relations);
            if (!$author) {
                return response()->json(['error' => 'Author not found.'], 404);
            }
            return new AuthorResource($author);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve author.'], 500);
        }
    }

    public function update(UpdateAuthorRequest $request, $id)
    {
        try {
            $author = $this->authorService->update($request->validated(), $id);
            if (!$author) {
                return response()->json(['error' => 'Author not found.'], 404);
            }
            return new AuthorResource($author);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update author.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = $this->authorService->delete($id);
            if (!$deleted) {
                return response()->json(['error' => 'Author not found.'], 404);
            }
            return response()->json(['message' => 'Author deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete author.'], 500);
        }
    }
}
