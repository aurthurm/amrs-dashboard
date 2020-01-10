<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\AmrdataService;

class AmrdataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Service\AmrdataService', function ($app) {
              return new AmrdataService();
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
