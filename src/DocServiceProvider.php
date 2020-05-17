<?php

namespace Foryoufeng\Doc;

use Illuminate\Support\ServiceProvider;
use Foryoufeng\Doc\Console\InstallCommand;

class DocServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // Publishing doc files.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/laravel-doc'),
            __DIR__.'/../config/laravel_doc.php' => config_path('laravel_doc.php'),
            __DIR__.'/../resources/views' => resource_path('views/docs'),
            __DIR__.'/../resources/mds' => resource_path('mds'),
            __DIR__.'/../resources/controllers' => app_path('Http/Controllers/Docs'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     */
    public function register()
    {
    }
}
