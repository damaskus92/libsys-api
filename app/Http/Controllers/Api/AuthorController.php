<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Repositories\Author\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $authors = Cache::remember('authors_all', 60, function () {
            return $this->authorRepository->all();
        });

        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $author = $this->authorRepository->create($request->validated());

        Cache::forget('authors_all');

        return (new AuthorResource($author))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): AuthorResource|JsonResponse
    {
        $author = Cache::remember("authors_{$id}", 60, function () use ($id) {
            return $this->authorRepository->find($id);
        });

        if (!$author || empty($author)) {
            return response()->json([
                'message' => 'Author not found.'
            ], 404);
        }

        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): AuthorResource|JsonResponse
    {
        $author = $this->authorRepository->find($id);

        if (!$author || empty($author)) {
            return response()->json([
                'message' => 'Author not found.'
            ], 404);
        }

        $author->update($request->validated());

        Cache::forget("authors_{$id}");
        Cache::forget('authors_all');

        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $author = $this->authorRepository->find($id);

        if (!$author || empty($author)) {
            return response()->json([
                'message' => 'Author not found.'
            ], 404);
        }

        $author->delete();

        Cache::forget("authors_{$id}");
        Cache::forget('authors_all');

        return response()->json([
            'message' => 'Author deleted successfully.'
        ], 200);
    }

    /**
     * Retrieve all books by a specific author.
     */
    public function books($id): AuthorResource
    {
        $author = Cache::remember("authors_{$id}_books", 60, function () use ($id) {
            return $this->authorRepository->getBooksByAuthor($id);
        });

        return new AuthorResource($author);
    }
}
