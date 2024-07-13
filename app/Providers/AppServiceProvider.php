<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Mail;
use App\Models\Sanctum\SanctumPersonalAccessToken;

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

        Sanctum::usePersonalAccessTokenModel(SanctumPersonalAccessToken::class);

    }


}
