<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\FacilitiesService;

class FacilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Service\FacilitiesService', function ($app) {
              return new FacilitiesService();
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
