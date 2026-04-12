<?php

namespace App\Providers;

use App\Models\Heartbeat;
use App\Repositories\Interfaces\HeartbeatRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\HeartbeatRepository;
use App\Repositories\Interfaces\ConnectionRepositoryInterface;
use App\Repositories\EloquentConnectionRepository;
use App\Interfaces\DecryptorInterface;
use App\Services\MRemoteAdapterService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
        $this->app->bind(
            HeartbeatRepositoryInterface::class,
            HeartbeatRepository::class
        );
        $this->app->bind(
            ConnectionRepositoryInterface::class,
            EloquentConnectionRepository::class
        );
        $this->app->bind(
            DecryptorInterface::class,
            MRemoteAdapterService::class
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
