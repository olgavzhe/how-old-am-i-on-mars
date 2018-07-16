<?php

namespace SillyDevelopment\HowOldAmIOnMars\Provider;

use Illuminate\Support\ServiceProvider;
use SillyDevelopment\HowOldAmIOnMars\Service\HowOldAmIOnMars;

/**
 * Class HowOldAmIOnMarsServiceProvider
 * @package SillyDevelopment\HowOldAmIOnMars\Provider
 */
class HowOldAmIOnMarsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Routes
        $this->loadRoutesFrom(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'routes.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '2018_05_17_100543_create_login_histories_table.php');
        $this->loadMigrationsFrom(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '2018_05_16_091940_create_requests_histories_table.php');

        // Views
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources/views',
            'how-old-am-i-on-mars');

        // Publish
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '2018_05_17_100543_create_login_histories_table.php'    => database_path('migrations'),
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR . '2018_05_16_091940_create_requests_histories_table.php' => database_path('migrations')
        ], 'migrations');
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'resources/views' => resource_path('views/vendor/sillydevelopment'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        /* $this->mergeConfigFrom(
             __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'auth.php',
             'auth'
         );*/

        $this->app->bind(HowOldAmIOnMars::class, function ($app) {
            return new HowOldAmIOnMars();
        });
    }
}
