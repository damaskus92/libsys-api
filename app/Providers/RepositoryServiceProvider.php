<?php

namespace App\Providers;

use App\Repositories;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            Repositories\Author\AuthorRepositoryInterface::class,
            Repositories\Author\AuthorRepository::class
        );

        $this->app->bind(
            Repositories\Book\BookRepositoryInterface::class,
            Repositories\Book\BookRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
