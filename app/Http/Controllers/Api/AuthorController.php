<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Repositories\Author\AuthorRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
        $authors = $this->authorRepository->all();

        return AuthorResource::collection($authors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $author = $this->authorRepository->create($request->validated());

        return (new AuthorResource($author))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): AuthorResource
    {
        $author = $this->authorRepository->find($id);

        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): AuthorResource
    {
        $author = $this->authorRepository->find($id);
        $author->update($request->validated());

        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $author = $this->authorRepository->find($id);
        $author->delete();

        return response()->json([
            'message' => 'Author deleted successfully.'
        ], 200);
    }

    /**
     * Retrieve all books by a specific author.
     */
    public function books($id): AuthorResource
    {
        $author = $this->authorRepository->getBooksByAuthor($id);

        return new AuthorResource($author);
    }
}
