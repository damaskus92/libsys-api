<?php

namespace App\Repositories\Author;

use App\Models\Author;
use App\Repositories\Repository;

class AuthorRepository extends Repository implements AuthorRepositoryInterface
{
    protected $model;

    public function __construct(Author $author)
    {
        $this->model = $author;
    }
}
