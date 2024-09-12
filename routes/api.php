<?php

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/authors/{id}/books', [AuthorController::class, 'books'])
    ->name('authors.books');
Route::apiResource('authors', AuthorController::class)
    ->parameters([
        'authors' => 'id',
    ]);

Route::apiResource('books', BookController::class)
    ->parameters([
        'authors' => 'id',
    ]);
