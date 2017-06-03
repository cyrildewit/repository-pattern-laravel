<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Course Repository
        $this->app->singleton(
            \App\Repositories\Course\CourseRepositoryInterface::class,
            \App\Repositories\Course\CourseEloquentRepository::class
        );

        // User Repository
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserEloquentRepository::class
        );

        // User Activation Repository
        $this->app->singleton(
            \App\Repositories\UserActivation\UserActivationRepositoryInterface::class,
            \App\Repositories\UserActivation\UserActivationDatabaseRepository::class
        );
    }
}
