<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //If the status is not 1(active) the user will be redirect to login 
        if (Auth::check() && Auth::user()->status != 1) {
            Auth::logout();

            alert()->error(__('global.alerts.messages.your_account_is_disabled'), __('global.alerts.messages.contact_system_admin'));
            return redirect('/login')->withInput();
        }

        return $response;
    }
}
