<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
    public function boot()
{
    if (app()->environment('local')) {
        \Illuminate\Support\Facades\DB::listen(function ($query) {
            \Illuminate\Support\Facades\Log::info($query->sql, $query->bindings);
        });
    }
}
}
