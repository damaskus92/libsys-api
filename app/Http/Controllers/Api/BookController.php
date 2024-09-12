<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Book\BookRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    protected $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $books = Cache::remember('books_all', 60, function () {
            return $this->bookRepository->all();
        });

        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $book = $this->bookRepository->create($request->validated());

        Cache::forget('books_all');

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): BookResource|JsonResponse
    {
        $book = Cache::remember("books_{$id}", 60, function () use ($id) {
            return $this->bookRepository->find($id);
        });

        if (!$book || empty($book)) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id): BookResource|JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book || empty($book)) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        $book->update($request->validated());

        Cache::forget("books_{$id}");
        Cache::forget('books_all');

        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $book = $this->bookRepository->find($id);

        if (!$book || empty($book)) {
            return response()->json([
                'message' => 'Book not found.'
            ], 404);
        }

        $book->delete();

        Cache::forget("books_{$id}");
        Cache::forget('books_all');

        return response()->json([
            'message' => 'Book deleted successfully.'
        ], 200);
    }
}
