<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\CommonService;

class CommonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // service container bindings

        $this->app->bind('App\Service\CommonService', function ($app) {
              return new CommonService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //use already registered services via the register method
        //this method is called after all other service providers have been registered
        
    }
}
