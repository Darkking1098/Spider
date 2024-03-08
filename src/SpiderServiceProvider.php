<?php

namespace Vector\Spider;

use Vector\Spider\Http\Middleware\AdminApiAuthMiddleware;
use Vector\Spider\Http\Middleware\AdminAuthMiddleware;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Route;

class SpiderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        $ADMIN_ROUTES = base_path('routes/admin.php');
        $ADMIN_API_ROUTES = base_path('routes/api_admin.php');

        // Creating Files if not found
        if (!is_file($ADMIN_ROUTES)) fclose(fopen($ADMIN_ROUTES, 'w'));
        if (!is_file($ADMIN_API_ROUTES)) fclose(fopen($ADMIN_API_ROUTES, 'w'));

        // Loading Routes
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php");
        // Loading Views
        $this->loadViewsFrom(__DIR__ . "/views", "Spider");

        // Admin Routes
        Route::middleware(['web', AdminAuthMiddleware::class])->prefix('admin')->group(__DIR__ . '/routes/admin.php')->group($ADMIN_ROUTES);

        // Admin Routes
        Route::middleware(['api', AdminApiAuthMiddleware::class])->prefix('api/admin')->group(__DIR__ . '/routes/api_admin.php')->group($ADMIN_API_ROUTES);

        // Copy resources to spider folder
        $this->publishes([
            __DIR__ . '/public' => public_path('vector/spider')
        ], 'spider-public');

        $this->publishes([
            __DIR__ . 'config.php' => config_path('vector.php'),
        ], 'spider-config');
    }
}
