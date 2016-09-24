<?php
namespace Star\Health;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class HealthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
            // Publish the migration
            $timestamp = '1949_07_15_100000';
            $this->publishes([
            __DIR__.'/resources/config/health.php' => $this->app->configPath().'/'.'health.php',
        ], 'config');
            $this->publishes([
                __DIR__.'/resources/migrations/create_health_tables.php.stub' => $this->app->databasePath().'/migrations/'.$timestamp.'_create_health_tables.php',
            ], 'migrations');
    }

    public function register()
    {
        $this->setupRoutes($this->app->router);
        $this->app->bind('Star\\Health\\Repos\\Contracts\\iPop', 'Star\\Health\\Repos\\Eloquent\\PopRepo');
        $this->app->bind('Star\\Health\\Repos\\Contracts\\iPopHealthRecord', 'Star\\Health\\Repos\\Eloquent\\PopHealthRecordRepo');
    }
    
    private function setupRoutes (Router $router)
    {
        $router->group(['namespace' => 'Star\Health\Controllers'], function ($router) {
            require __DIR__. '/routes.php';
        });
    }
}
