<?php

use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;

use function Pest\Laravel\{
    delete,
    get,
    post,
    put
};

it('can fetch all books', function () {
    $books = Book::factory()->count(3)->create();

    $response = get('/api/books');

    $response->assertOk()
        ->assertExactJson(
            BookResource::collection($books)
                ->response()
                ->getData(true)
        );
});

it('can create a new book', function () {
    $author = Author::factory()->create();

    $book = [
        'title'        => 'New Book',
        'description'  => 'A description for a new book',
        'publish_date' => '2024-01-01',
        'author_id'    => $author->id,
    ];

    $response = post('/api/books', $book);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'publish_date',
                // 'author_id',
            ],
        ]);

    $this->assertDatabaseHas('books', $book);
});

it('can fetch a specific book', function () {
    $book = Book::factory()->create();

    $response = get("/api/books/{$book->id}");

    $response->assertOk()
        ->assertExactJson(
            (new BookResource($book))
                ->response()
                ->getData(true)
        );
});

it('can update an existing book', function () {
    $book = Book::factory()->create();

    $updatedBook = [
        'title'        => 'Updated Book Title',
        'description'  => 'Updated description',
        'publish_date' => '2025-02-02',
        'author_id'    => $book->author_id,
    ];

    $response = put("/api/books/{$book->id}", $updatedBook);

    $response->assertOk()
        ->assertExactJson(
            (new BookResource($book->refresh()))
                ->response()
                ->getData(true)
        );

    $this->assertDatabaseHas('books', $updatedBook);
});

it('can delete a book', function () {
    $book = Book::factory()->create();

    $response = delete("/api/books/{$book->id}");

    $response->assertOk()
        ->assertJson([
            'message' => 'Book deleted successfully.'
        ]);

    $this->assertDatabaseMissing('books', [
        'id' => $book->id
    ]);
});
