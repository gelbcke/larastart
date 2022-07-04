<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * FronEnd
 */
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

/**
 * Unlock System
 */
Route::post('/login/locked', [App\Http\Controllers\Auth\LoginController::class, 'unlock'])
    ->name('login.unlock');

/**
 * Backend Routes
 */
Route::group(['middleware' => ['auth', 'check_user_status', 'check_user_single_session', 'auth.lock', '2fa', 'language']], function () {

    /**
     * Dashboard / Home
     */
    Route::get('/home', [App\Http\Controllers\Backend\HomeController::class, 'index'])
        ->name('home');

    /**
     * Lockscreen
     */
    Route::get('/login/locked', [App\Http\Controllers\Auth\LoginController::class, 'locked'])
        ->withoutMiddleware('auth.lock')->name('login.locked');

    /**
     * User / Profile
     */
    Route::controller(App\Http\Controllers\Backend\UserController::class)->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', 'index')->name('users.index');
            Route::get('/create', 'create')->name('users.create');
            Route::get('/edit/{user}', 'edit')->name('users.edit');
            Route::post('/store', 'store')->name('users.store');
            Route::patch('/update/{user}', 'update')->name('users.update');
            Route::get('/getUsers', 'getUsers')->name('users.get');
            Route::get('/{language}', 'change_language')->name('lang.update');
            Route::get('/lockscreen', 'lockscreen')->name('users.lockscreen');
            Route::get('/activate/{id}', 'active')->name('users.active');
            Route::get('/deactivate/{id}', 'deactive')->name('users.deactive');
        });
        Route::prefix('profile')->group(function () {
            Route::get('/{user}', 'user_profile')->name('user.profile');
            Route::get('/my_profile/{user}', 'profile')->name('profile');
            Route::patch('/{user}', 'update_profile')->name('profile.update');
        });
    });

    /**
     * System Settings
     */
    Route::controller(App\Http\Controllers\Backend\SystemSettingController::class)->group(function () {
        Route::prefix('system')->group(function () {
            Route::get('/settings', 'index')->name('system_settings');
            Route::get('/settings/edit', 'settings')->name('system_settings.edit');
            Route::post('/settings/edit', 'update')->name('system_settings.update');
        });
    });

    /**
     * Logs
     */
    Route::controller(App\Http\Controllers\Backend\LogController::class)->group(function () {
        Route::prefix('log')->group(function () {
            Route::get('/', 'index')->name('logs.index');
            Route::get('/getLogs', 'getLogs')->name('logs.get');
            Route::get('/clearLogs', 'clearLogs')->name('logs.clear');
        });
    });

    /**
     * 2FA
     */
    Route::controller(App\Http\Controllers\Backend\LoginSecurityController::class)->group(function () {
        Route::prefix('2fa')->group(function () {
            Route::any('/', 'show2faForm')->name('2fa');
            Route::post('/secret',  'generate2faSecret')->name('generate2faSecret');
            Route::post('/enable', 'enable2fa')->name('enable2fa');
            Route::post('/disable', 'disable2fa')->name('disable2fa');
        });
    });

    /**
     * Roles and permissions
     */
    Route::resource('/roles', App\Http\Controllers\RoleController::class);
    Route::resource('/permissions', App\Http\Controllers\PermissionController::class);

    /**
     * 2FA middleware
     */
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify');
});
