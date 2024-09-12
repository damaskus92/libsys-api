<?php

namespace App\Repositories\Author;

use App\Repositories\RepositoryInterface;

interface AuthorRepositoryInterface extends RepositoryInterface
{
    public function getBooksByAuthor($id);
}
