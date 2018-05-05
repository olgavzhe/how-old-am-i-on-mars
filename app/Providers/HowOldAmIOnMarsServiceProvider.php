<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Library\Service\HowOldAmIOnMars;

class HowOldAmIOnMarsServiceProvider extends ServiceProvider
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
        $this->app->bind(HowOldAmIOnMars::class, function ($app) {
            return new HowOldAmIOnMars();
        });
    }
}
