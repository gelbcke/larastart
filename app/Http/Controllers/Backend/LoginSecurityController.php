<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\LoginSecurity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LoginSecurityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show 2FA Setting form
     */
    public function show2faForm(Request $request)
    {
        $user = Auth::user();
        $google2fa_url = "";
        $secret_key = "";

        if ($user->loginSecurity()->exists()) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }

        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url
        );

        return view('auth.2fa_settings')->with('data', $data);
    }

    /**
     * Generate 2FA secret key
     */
    public function generate2faSecret(Request $request)
    {
        $user = Auth::user();
        // Initialise the 2FA class
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        // Add the secret key to the registration data
        $login_security = LoginSecurity::firstOrNew(array('user_id' => $user->id));
        $login_security->user_id = $user->id;
        $login_security->google2fa_enable = 0;
        $login_security->google2fa_secret = $google2fa->generateSecretKey();
        $login_security->save();

        return redirect('/2fa')->with('success', __('2fa.alerts.key_generated'));
    }

    /**
     * Enable 2FA
     */
    public function enable2fa(Request $request)
    {
        $user = Auth::user();
        $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());

        $secret = $request->input('secret');
        $valid = $google2fa->verifyKey($user->loginSecurity->google2fa_secret, $secret);

        if ($valid) {
            $user->loginSecurity->google2fa_enable = 1;
            $user->loginSecurity->save();

            activity()
                ->causedBy(Auth::user()->id)
                ->event('activated')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = '2FA';
                    $activity->subject_type = 'App\Models\LoginSecurity';
                    $activity->ip = $request->ip();
                })
                ->log('User ID: ' . $user->id . ' has activate 2FA login');

            return redirect('2fa')->with('success', __('2fa.alerts.2fa_enabled'));
        } else {
            return redirect('2fa')->with('warning', __('2fa.alerts.invalid_code'));
        }
    }

    /**
     * Disable 2FA
     */
    public function disable2fa(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {

            return redirect()->back()->with("warning", __('2fa.alerts.wrong_password'));
        } else {

            $user = Auth::user();
            $user->loginSecurity->google2fa_enable = 0;
            $user->loginSecurity->save();

            activity()
                ->causedBy(Auth::user()->id)
                ->event('deactivated')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = '2FA';
                    $activity->subject_type = 'App\Models\LoginSecurity';
                    $activity->ip = $request->ip();
                })
                ->log('User ID: ' . $user->id . ' has deactivated 2FA login');

            return redirect('/2fa')->with('success', __('2fa.alerts.2fa_disabled'));
        }
    }
}
