<?php

namespace SillyDevelopment\HowOldAmIOnMars\Provider;

use Illuminate\Support\ServiceProvider;
use SillyDevelopment\HowOldAmIOnMars\Service\Facebook;

/**
 * Class FacebookServiceProvider
 * @package SillyDevelopment\HowOldAmIOnMars\Provider
 */
class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'2018_07_16_070706_users_add_facebook.php');

        // Views
        $this->loadViewsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'/resources/views', 'facebook');

        // Publish
        $this->publishes([
            __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR.'2018_07_16_070706_users_add_facebook.php' => database_path('migrations')
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Facebook::class, function ($app) {
            return new Facebook();
        });
    }
}
