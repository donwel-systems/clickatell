<?php

namespace DonwelSystems\Clickatell;
use DonwelSystems\Clickatell\Services\Central;
use DonwelSystems\Clickatell\Services\Platform;
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


        if ($this->getChannel() == 'central')
        {
            $this->app->singleton('clickatell', function($app) {
                return new Central();
            });
        } else
        {
            $this->app->singleton('clickatell', function($app) {
                return new Platform();
            });
        }

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

    /**
     *  Get the clickatel channel  based on config file
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->app['config']->get('clickatell.channel', 'central');


    }


}
