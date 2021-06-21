<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\helper\Helper;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Helper', function(){
            return new Helper();
        } );
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
