<?php

use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\Book;

use function Pest\Laravel\{
    delete,
    get,
    post,
    put
};

it('can fetch all authors', function () {
    $authors = Author::factory()->count(3)->create();

    $response = get('/api/authors');

    $response->assertOk()
        ->assertExactJson(
            AuthorResource::collection($authors)
                ->response()
                ->getData(true)
        );
});

it('can create a new author', function () {
    $author = [
        'name'       => 'Damas Eka Kusuma',
        'bio'        => 'An amazing author',
        'birth_date' => '1992-09-15',
    ];

    $response = post('/api/authors', $author);

    $response->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'bio',
                'birth_date',
            ],
        ]);

    $this->assertDatabaseHas('authors', $author);
});

it('cannot create an author with empty data', function () {
    $author = [
        'name'       => '',
        'bio'        => '',
        'birth_date' => '',
    ];

    post('/api/authors', $author)
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'name',
            'bio',
            'birth_date',
        ]);
});

it('cannot create an author with wrong date format', function () {
    $author = [
        'birth_date' => '12-12-2024',
    ];

    post('/api/authors', $author)
        ->assertUnprocessable()
        ->assertJsonValidationErrors([
            'birth_date',
        ]);
});

it('can fetch a specific author', function () {
    $author = Author::factory()->create();

    $response = get("/api/authors/{$author->id}");

    $response->assertOk()
        ->assertExactJson(
            (new AuthorResource($author))
                ->response()
                ->getData(true)
        );
});

it('return 404 if fetching non-existent author', function () {
    get('/api/authors/999')
        ->assertNotFound()
        ->assertJson([
            'message' => 'Author not found.'
        ]);
});

it('can update an existing author', function () {
    $author = Author::factory()->create();

    $updatedAuthor = [
        'name'       => 'Damas Eka Kusuma',
        'bio'        => 'An amazing author',
        'birth_date' => '1992-09-15',
    ];

    $response = put("/api/authors/{$author->id}", $updatedAuthor);

    $response->assertOk()
        ->assertExactJson(
            (new AuthorResource($author->refresh()))
                ->response()
                ->getData(true)
        );

    $this->assertDatabaseHas('authors', $updatedAuthor);
});

it('can delete an author', function () {
    $author = Author::factory()->create();

    $response = delete("/api/authors/{$author->id}");

    $response->assertOk()
        ->assertJson([
            'message' => 'Author deleted successfully.'
        ]);

    $this->assertDatabaseMissing('authors', [
        'id' => $author->id
    ]);
});

it('can fetch all books by a specific author', function () {
    $author = Author::factory()
        ->has(Book::factory()->count(3), 'books')
        ->create();

    $response = get("/api/authors/{$author->id}/books");

    $response->assertOk()
        ->assertJsonCount(3, 'data.books');
});
