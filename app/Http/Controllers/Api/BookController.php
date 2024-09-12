<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
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
     * List books.
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $books = Cache::remember('books_all', 60, function () {
            return $this->bookRepository->all();
        });

        return BookResource::collection($books);
    }

    /**
     * Create new book.
     *
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\BookRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        $book = $this->bookRepository->create($request->validated());

        Cache::forget('books_all');

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Show book.
     *
     * Display the specified resource.
     *
     * @param int|mixed $id Book ID to be retrieved.
     *
     * @return \App\Http\Resources\BookResource|\Illuminate\Http\JsonResponse
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
     * Update book.
     *
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\BookRequest $request
     * @param int|mixed $id Book ID to be updated.
     *
     * @return \App\Http\Resources\BookResource|\Illuminate\Http\JsonResponse
     */
    public function update(BookRequest $request, $id): BookResource|JsonResponse
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
     * Delete book.
     *
     * Remove the specified resource from storage.
     *
     * @param int|mixed $id Book ID to be deleted.
     *
     * @return \Illuminate\Http\JsonResponse
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
