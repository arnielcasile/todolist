<?php

namespace App\Providers;

use App\Repositories\Contracts\TodoListContract;
use App\Repositories\TodoListRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            TodoListContract::class,
            TodoListRepository::class
        );
    }
}
