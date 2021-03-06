<?php

namespace ViralsBackpack\BackPackImageUpload;

use Illuminate\Support\ServiceProvider;

class BackPackImageUploadServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'viralsbackpack');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'viralsbackpack');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $config = $this->app['config']->get('elfinder', []);
        if (file_exists(config_path('backpackimageupload.php'))) {
            $configBackpack = $this->app['config']->get('backpackimageupload', []);
        } else {
            $configBackpack = require __DIR__.'/../config/backpackimageupload.php';
        }
        $this->app['config']->set('elfinder', array_merge($config, $configBackpack['elfinder']));

        $folderStorage = str_replace("storage","app/public", $this->app['config']->get('elfinder', [])['dir'][0]);
        if (!file_exists(storage_path($folderStorage))) {
            mkdir(storage_path($folderStorage), 0777, true);
        }

        // Register the service the package provides.
        $this->app->singleton('backpackimageupload', function ($app) {
            return new BackPackImageUpload;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['backpackimageupload'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/backpackimageupload.php' => config_path('backpackimageupload.php'),
        ], 'backpackimageupload.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/backpack/crud/fields/'),
        ], 'backpackimageupload.views');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/viralsbackpack'),
        ], 'backpackimageupload.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/viralsbackpack'),
        ], 'backpackimageupload.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
