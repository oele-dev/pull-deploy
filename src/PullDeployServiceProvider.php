<?php

namespace oeleco\PullDeploy;

use Illuminate\Support\ServiceProvider;

class PullDeployServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('pull-deploy.php'),
            ], 'config');
            // Registering package commands.
            $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'pull-deploy');

        // Register the main class to use with the facade
        $this->app->singleton('pull-deploy', function () {
            return new PullDeploy;
        });
    }
}
