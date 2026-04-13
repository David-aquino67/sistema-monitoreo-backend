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

use App\Repositories\Interfaces\MonitorRepositoryInterface; 
use App\Repositories\MonitorRepository; 

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
       $this->app->bind(
        MonitorRepositoryInterface::class,
        MonitorRepository::class
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
