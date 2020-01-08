<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\UsersService;

class UsersServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Service\UsersService', function ($app) {
              return new UsersService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
