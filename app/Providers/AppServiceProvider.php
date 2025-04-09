<?php

namespace App\Providers;

use App\Service\CustomPassportProvider;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Socialite;

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
        
        Passport::tokensExpireIn(now()->addMillisecond(15000));
        Socialite::extend('passport', function ($app) {
            $config = $app['config']['services.passport'];
            return Socialite::buildProvider(CustomPassportProvider::class, $config);
        });
    }
}
