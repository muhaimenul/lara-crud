<?php

namespace Muhaimenul\Laracrud;

use Illuminate\Support\ServiceProvider;

class LaracrudServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->publishes([
//            __DIR__ . '/../config/laracrud.php' => config_path('laracrud.php'),
//        ]);
//        $this->publishes([
//            __DIR__ . '/../publish/views/' => base_path('resources/views/'),
//        ]);
//        if (\App::VERSION() <= '5.2') {
//            $this->publishes([
//                __DIR__ . '/../publish/css/app.css' => public_path('css/app.css'),
//            ]);
//        }
        $this->publishes([
            __DIR__ . '/stubs/' => base_path('resources/lara-crud/'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            'Muhaimenul\Laracrud\Commands\GenerateCRUD'
        );
    }
}
