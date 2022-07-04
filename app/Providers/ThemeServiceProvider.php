<?php

namespace App\Providers;

use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
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

                $avl_themes = collect([

                    (object) [
                        'name' => 'Default',
                        'body' => 'sidebar-mini layout-fixed layout-navbar-fixed sidebar-mini-xs sidebar-mini-md text-sm sidebar-collapse',
                        'nav'  => 'main-header navbar navbar-expand navbar-white navbar-light'
                    ],
                    (object) [
                        'name' => 'Default Dark',
                        'body' => 'dark-mode sidebar-mini layout-fixed layout-navbar-fixed sidebar-mini-xs sidebar-mini-md text-sm sidebar-collapse',
                        'nav'  => 'main-header navbar navbar-expand navbar-dark'
                    ],
                    (object) [
                        'name' => 'Big Light',
                        'body' => 'layout-fixed layout-navbar-fixed',
                        'nav'  => 'main-header navbar navbar-expand navbar-white navbar-light'
                    ],
                    (object) [
                        'name' => 'Big Dark',
                        'body' => 'dark-mode layout-fixed layout-navbar-fixed',
                        'nav'  => 'main-header navbar navbar-expand navbar-dark'
                    ],
                    (object) [
                        'name' => 'Open Sidebar Light',
                        'body' => 'sidebar-mini layout-fixed layout-navbar-fixed sidebar-mini-xs sidebar-mini-md text-sm',
                        'nav'  => 'main-header navbar navbar-expand navbar-white navbar-light'
                    ],
                    (object) [
                        'name' => 'Open Sidebar Dark',
                        'body' => 'dark-mode sidebar-mini layout-fixed layout-navbar-fixed sidebar-mini-xs sidebar-mini-md text-sm',
                        'nav'  => 'main-header navbar navbar-expand navbar-dark'
                    ],
                    (object) [
                        'name' => 'Hide Sidebar Light',
                        'body' => 'sidebar-collapse layout-fixed layout-navbar-fixed text-sm',
                        'nav'  => 'main-header navbar navbar-expand navbar-white navbar-light'
                    ],
                    (object) [
                        'name' => 'Hide Sidebar Dark',
                        'body' => 'dark-mode sidebar-collapse layout-fixed layout-navbar-fixed text-sm',
                        'nav'  => 'main-header navbar navbar-expand navbar-dark'
                    ]
                ]);

                $apply_theme = $avl_themes->where('name', auth()->user()->theme);

                View::share(compact([
                    'apply_theme',
                    'avl_themes'
                ]));
            }
        });
    }
}
