<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\ModulesRepository::class, \App\Repositories\ModulesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UsersModulesRepository::class, \App\Repositories\UsersModulesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UsersModulesActionsRepository::class, \App\Repositories\UsersModulesActionsRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UsersRepository::class, \App\Repositories\UsersRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\UsersCheckRepository::class, \App\Repositories\UsersCheckRepositoryEloquent::class);
        //:end-bindings:
    }
}
