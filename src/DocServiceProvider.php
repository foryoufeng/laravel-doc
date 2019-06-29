<?php

namespace Foryoufeng\Doc;

use Illuminate\Support\ServiceProvider;

class DocServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        if(!file_exists(config_path('laravel_doc.php'))){
            file_put_contents(
                base_path('routes/web.php'),
                file_get_contents(__DIR__.'/../resources/routes/route.php'),
                FILE_APPEND
            );
        }
        // Publishing doc files.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/laravel-doc'),
            __DIR__.'/../config/laravel_doc.php' => config_path('laravel_doc.php'),
            __DIR__.'/../resources/views' => resource_path('views/docs'),
            __DIR__.'/../resources/mds' => resource_path('mds'),
            __DIR__.'/../resources/controllers' => app_path('Http/Controllers/Docs'),
        ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

    }


}
