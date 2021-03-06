<?php

namespace App\Providers;

use App\Models\SystemSetting;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\Composer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        /**
         * Will assign created user to "USER" role
         */
        User::observe(UserObserver::class);

        /**
         * Share System Settings on views
         */
        $viewPaths = ['welcome', 'layouts.app', 'backend.user.profile.*', 'backend.system.*'];

        View::composer($viewPaths, function ($view) {

            if (Auth::check()) {
                //Set Language of user
                $user_language = Auth::user()->language;

                App::setLocale($user_language);
                session()->put("language", $user_language);
            }

            $app_s = SystemSetting::first();

            date_default_timezone_set($app_s->timezone->name);

            View::share(compact('app_s'));
        });
    }
}
