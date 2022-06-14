<?php

namespace App\Providers;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
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
        View::composer('*', function ($view) {

            if (Auth::check()) {
                //Set Language of user
                App::setLocale(Auth::user()->language);
                session()->put("language", Auth::user()->language);
            }

            $app_s = SystemSetting::first();

            $app_currency = SystemSetting::first()->currency->symbol;
            $app_timezone = SystemSetting::first()->timezone->name;

            date_default_timezone_set($app_timezone);

            View::share(
                compact([
                    'app_s',
                    'app_currency',
                    'app_timezone'
                ])
            );
        });
    }
}
