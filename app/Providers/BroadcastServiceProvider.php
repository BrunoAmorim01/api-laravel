<?php

namespace App\Providers;

use Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Broadcast::routes(['prefix' => 'api', 'middleware' => ['auth:sanctum']]);

        require base_path('routes/channels.php');
    }
}
