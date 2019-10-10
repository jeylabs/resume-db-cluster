<?php

namespace Jeylabs\ResumeDbCluster;

use Illuminate\Support\ServiceProvider;
use Jeylabs\ResumeDbCluster\Middleware\ResumeDbClusterMiddleware;

class ResumeDbClusterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        /** @var Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', ResumeDbClusterMiddleware::class);

        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'resume-db-cluster');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'resume-db-cluster');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('resume-db-cluster.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/resume-db-cluster'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/resume-db-cluster'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/resume-db-cluster'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'resume-db-cluster');

        // Register the main class to use with the facade
        $this->app->singleton('resume-db-cluster', function () {
            return new ResumeDbCluster;
        });
    }
}
