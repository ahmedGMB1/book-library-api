<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\BookService;
use App\Services\AuthorService;
use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\BookServiceInterface;
use App\Services\Interfaces\AuthorServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AuthorServiceInterface::class, AuthorService::class);
        $this->app->bind(BookServiceInterface::class, BookService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
