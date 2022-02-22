<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResetPassword::createUrlUsing(function($notifiable,$token){
            return "http://localhost:8080/reset-password/{$token}?email={$notifiable->getEmailForPasswordReset()}";
        });
        setlocale(LC_TIME, 'fr_FR', 'fr', 'FR', 'French', 'fr_FR.UTF-8');
        Carbon::setLocale('fr'); // T
    }
}
