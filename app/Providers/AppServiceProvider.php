<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // DB::statement('SET SESSION sql_require_primary_key=0');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // App Environment.
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        // App Db Schema.
        Schema::defaultStringLength(191);
    }
}
