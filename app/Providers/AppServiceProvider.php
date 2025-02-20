<?php

namespace App\Providers;

use App\Models\Platform;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
    public function boot(): void
    {
        $platform = Platform::first();

        $platformName = $platform->name ?? 'Laravel'; 
        $platformImage = $platform->logo ?? asset('images/logo-icon.png'); 
        
        View::share([
            'platformName' => $platformName,
            'platformImage' => $platformImage
        ]);

        Paginator::useBootstrap();
    }
}
