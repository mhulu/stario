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
