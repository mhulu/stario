<?php

namespace Star\Icenter;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class IcenterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__. '/resources/views', 'icenter');

        $this->publishes([
            __DIR__.'/resources/config/icenter.php' => $this->app->configPath().'/'.'icenter.php',
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/lang/zh-cn' => resource_path('lang/zh-cn'),
        ], 'lang');

        $this->publishes([
        __DIR__.'/resources/assets' => public_path('assets'),
    ], 'public');

        if (!class_exists('CreateIcenterTables')) {
            // Publish the migration
            $timestamp = '1949_07_15_100000';
            $this->publishes([
                __DIR__.'/resources/migrations/create_icenter_tables.php.stub' => $this->app->databasePath().'/migrations/'.$timestamp.'_create_icenter_tables.php',
            ], 'migrations');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->setupRoutes($this->app->router);
    }
    
    private function setupRoutes (Router $router)
    {
        $router->group(['namespace' => 'Star\Icenter\Controllers'], function ($router) {
            require __DIR__. '/routes.php';
        });
    }
}
