<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Service\Facebook;

/**
 * Class FacebookServiceProvider
 * @package App\Providers
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
        //
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
