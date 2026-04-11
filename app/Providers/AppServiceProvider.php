<?php

namespace App\Providers;

use App\Models\Heartbeat;
use App\Repositories\Interfaces\HeartbeatRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\HeartbeatRepositoryInterface::class,
            \App\Repositories\HeartbeatRepository::class,
            \App\Repositories\Interfaces\ConnectionRepositoryInterface::class,
            \App\Repositories\EloquentConnectionRepository::class
        );
    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {
        //
    }
}
