<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Blade::component('layouts.app', 'admin-layout');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
