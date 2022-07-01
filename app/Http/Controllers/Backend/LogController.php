<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Validation\ValidationException;
use DataTables;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
        $this->middleware('permission:logs-list', ['only' => ['index', 'getLogs']]);
        $this->middleware('permission:logs-clear', ['only' => 'clearLogs']);
    }

    /**
     * Show the application log.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.log.index');
    }


    public function getLogs()
    {
        $dump = Activity::all();

        return DataTables::of($dump)
            ->addColumn('causer', function (Activity $activity) {
                return $activity->causer->name;
            })
            ->make(true);
    }

    public function clearLogs()
    {
        try {
            Artisan::call('activitylog:clean');

            Alert::success(__('global.alerts.success'), __(Artisan::output()));

            return back();
        } catch (\Exception $e) {
            throw new ValidationException($e);

            Alert::error(__('global.alerts.error'), $e);

            return back();
        }
    }
}
