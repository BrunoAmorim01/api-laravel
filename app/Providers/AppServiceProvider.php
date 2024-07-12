<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('local')) {
            Mail::alwaysTo('brunoamorim@protonmail.com');
        }

    }


}
