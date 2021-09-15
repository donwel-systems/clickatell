<?php

namespace DonwelSystems\Clickatell;
use DonwelSystems\Clickatell\Services\Clickatell;
use Illuminate\Support\ServiceProvider;

class ClickatellServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {


            $this->app->bind('clickatell', function($app) {
                return new Clickatell();
            });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/clickatell.php' =>  config_path('clickatell.php'),
        ], 'config');
    }


}
