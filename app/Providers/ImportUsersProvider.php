<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImportUsersService;
use App\Contracts\ImportUsersContract;
class ImportUsersProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ImportUsersContract::class, ImportUsersService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
