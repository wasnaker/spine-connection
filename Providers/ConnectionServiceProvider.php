<?php

declare(strict_types=1);

namespace Modules\Connection\Providers;

use Illuminate\Support\ServiceProvider;

class ConnectionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Aktor (entity aktif) di-resolve dari user login per request.
        $this->app->singleton(\Modules\Connection\Services\ActorResolver::class);
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
