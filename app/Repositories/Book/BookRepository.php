<?php

namespace App\Repositories\Book;

use App\Models\Book;
use App\Repositories\Repository;

class BookRepository extends Repository implements BookRepositoryInterface
{
    protected $model;

    public function __construct(Book $book)
    {
        $this->model = $book;
    }
}
