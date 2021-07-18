<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Repositories\AuthorRepository;
use App\Repositories\PublisherRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BookRepository;
use App\Repositories\UserRepository;
use App\Repositories\RepositoryInterface\AuthorRepositoryInterface;
use App\Repositories\RepositoryInterface\PublisherRepositoryInterface;
use App\Repositories\RepositoryInterface\CategoryRepositoryInterface;
use App\Repositories\RepositoryInterface\BookRepositoryInterface;
use App\Repositories\RepositoryInterface\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            AuthorRepositoryInterface::class,
            AuthorRepository::class,
        );
        $this->app->singleton(
            PublisherRepositoryInterface::class,
            PublisherRepository::class
        );
        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->singleton(
            BookRepositoryInterface::class,
            BookRepository::class
        );
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
