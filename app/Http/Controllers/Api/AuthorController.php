<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
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
     * List authors.
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $authors = Cache::remember('authors_all', 60, function () {
            return $this->authorRepository->all();
        });

        return AuthorResource::collection($authors);
    }

    /**
     * Create new author.
     *
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\AuthorRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AuthorRequest $request): JsonResponse
    {
        $author = $this->authorRepository->create($request->validated());

        Cache::forget('authors_all');

        return (new AuthorResource($author))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show author.
     *
     * Display the specified resource.
     *
     * @param int|mixed $id Author ID to be retrieved.
     *
     * @return \App\Http\Resources\AuthorResource|\Illuminate\Http\JsonResponse
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
     * Update author.
     *
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\AuthorRequest $request
     * @param int|mixed $id Author ID to be updated.
     *
     * @return \App\Http\Resources\AuthorResource|\Illuminate\Http\JsonResponse
     */
    public function update(AuthorRequest $request, $id): AuthorResource|JsonResponse
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
     * Delete author.
     *
     * Remove the specified resource from storage.
     *
     * @param int|mixed $id Author ID to be deleted.
     *
     * @return \Illuminate\Http\JsonResponse
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
     * List author books
     *
     * Displays the specified author with all books.
     *
     * @param int|mixed $id Author ID to retrieve list of all books.
     *
     * @return \App\Http\Resources\AuthorResource
     */
    public function books($id): AuthorResource
    {
        $author = Cache::remember("authors_{$id}_books", 60, function () use ($id) {
            return $this->authorRepository->getBooksByAuthor($id);
        });

        return new AuthorResource($author);
    }
}
