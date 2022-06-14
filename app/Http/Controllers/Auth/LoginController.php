<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->middleware('guest')->except([
            'logout',
            'locked',
            'unlock'
        ]);
    }

    function authenticated(Request $request, $user)
    {
        $app_timezone = SystemSetting::first()->timezone->name;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            $user->update([
                'last_login_at' => Carbon::now()->setTimezone($app_timezone)->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);

            activity()
                ->causedBy(Auth::user()->id)
                ->event('logged in')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = 'User';
                    $activity->subject_type = 'App\Models\User';
                    $activity->ip = $request->ip();
                })
                ->log('User ' . $user->id . ' logged on');

            toast(__('global.welcome_user', ['name' => Auth::user()->name]), 'success');
            return redirect('home');
        } else {
            alert()->error(__('global.alerts.messages.your_account_is_disabled'), __('global.alerts.messages.contact_system_admin'));
            return redirect('/login');
        }
    }

    public function locked()
    {
        if (!session('lock-expires-at')) {
            return redirect('/');
        }

        if (session('lock-expires-at') > now()) {
            return redirect('/');
        }

        return view('auth.locked');
    }

    public function unlock(Request $request)
    {
        $check = Hash::check($request->input('password'), $request->user()->password);

        if (!$check) {
            alert()->error(__('auth.unlock_failed'));
            return redirect()->route('login.locked');
        }

        activity()
            ->causedBy(Auth::user()->id)
            ->event('unlock')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Unlock System';
                $activity->subject_type = 'App\Models\LoginSecurity';
                $activity->ip = $request->ip();
            })
            ->log('User unlocked the system');

        toast(__('auth.unlock_success'), 'success');
        session(['lock-expires-at' => now()->addMinutes($request->user()->getLockoutTime())]);

        return redirect('home');
    }
}
