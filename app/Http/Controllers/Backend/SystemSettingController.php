<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Currencies;
use App\Models\SystemSetting;
use App\Models\Timezone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class SystemSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
        $this->middleware('permission:settings-list', ['only' => ['index', 'settings']]);
        $this->middleware('permission:settings-update', ['only' => 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = SystemSetting::get();
        return view('backend.system.index', compact('settings'));
    }

    public function settings()
    {
        $settings = SystemSetting::get();
        $currencies = Currencies::get();
        $timezones = Timezone::get();

        return view('backend.system.settings', compact('settings', 'currencies', 'timezones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemSetting  $systemSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemSetting $systemSetting)
    {
        try {
            SystemSetting::first()->update($request->all());

            activity()
                ->causedBy(Auth::user()->id)
                ->event('updated')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = 'System Settings';
                    $activity->subject_type = 'App\Models\SystemSetting';
                    $activity->ip = $request->ip();
                })
                ->log('System Settings has been updated');

            Alert::success(__('global.alerts.success'), __('system_settings.alerts.updated'));
            return redirect()->route('system_settings.edit');
        } catch (\Exception $e) {

            Alert::error(__('global.alerts.error'), __('system_settings.alerts.not_updated') . " " . $e);
            return redirect()->route('system_settings.edit')
                ->withInput();
        }
    }
}
