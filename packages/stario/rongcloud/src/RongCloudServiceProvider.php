<?php

namespace Star\rongcloud;

use Illuminate\Support\ServiceProvider;

class RongCloudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('rongcloud.php')
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RongCloud::class, function($app){
            return new RongCloud;
    }
}
