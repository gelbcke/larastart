<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Traits\UploadTrait;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    use UploadTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    if ($row->status == 1) {
                        $status_btn = '<a href="' . route("users.deactive", $row->id) . '" title="' . __('global.form.deactivate') . '" class="fa-solid fa-user-xmark" style="color: #dc3545"></a>';
                    } else {
                        $status_btn = '<a href="' . route("users.active", $row->id) . '"  title="' . __('global.form.activate') . '" class="fa-solid fa-user-check" style="color: #1e7e34"></a>';
                    }

                    $btn = '
                    <a href="' . route("user.profile", $row->id) . '" class="fa-solid fa-eye" title="' . __('global.form.view') . '" style="color: #0069d9; margin-right: 5px"></a>
                    ' . $status_btn . '
                    ';

                    return $btn;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('status') == '0' || $request->get('status') == '1') {
                        $instance->where('status', $request->get('status'));
                    }
                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%")
                                ->orWhere('email', 'LIKE', "%$search%");
                        });
                    }
                })
                ->editColumn('name', function ($user) {
                    return '<a href="' . route('profile', $user->id) . '">' . $user->name . '</a>  ';
                })
                ->editColumn('status', function ($inquiry) {
                    if ($inquiry->status == 0)
                        return '<span class="badge bg-danger"> ' . __('global.status.deactivated') . '</span>';
                    if ($inquiry->status == 1)
                        return  '<span class="badge bg-success">' . __('global.status.activated') . '</span>';
                    return 'Cancel';
                })
                ->rawColumns(['action', 'name', 'status'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function profile(User $user)
    {
        $languages = ([
            "en" => 'en',
            "pt_BR" => 'pt_BR'
        ]);

        return view('backend.user.profile', compact('user', 'languages'));
    }

    public function user_profile(User $user)
    {
        $languages = ([
            "en" => 'en',
            "pt_BR" => 'pt_BR'
        ]);

        return view('backend.user.user_profile', compact('user', 'languages'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'language'  => 'in:en,pt_BR',
            'theme' => 'in:Default,Default Dark,Mini Light,Mini Dark,Open Sidebar Light,Open Sidebar Dark,Hide Sidebar Light,Hide Sidebar Dark'
        ]);

        try {
            if ($user->id == Auth::user()->id) {
                Auth::user()->update($request->all());
            } else {
                $user->update($request->except(['theme', 'language', 'photo', 'notes']));
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $extension = $image->getClientOriginalExtension();
                $image_name = $user->id . "." . $extension;

                $destinationPath = public_path('/img/profiles');
                $image->move($destinationPath, $image_name);
                $user->update(['image' => $image_name]);
            }

            activity()
                ->causedBy(Auth::user()->id)
                ->event('updated')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = 'User';
                    $activity->subject_type = 'App\Models\User';
                    $activity->ip = $request->ip();
                })
                ->log('User ID: ' . $user->id . ' has been updated');

            Alert::success(__('global.alerts.success'), __('profile.alerts.profile_updated'));

            return back();
        } catch (\Exception $e) {
            throw new ValidationException($e);

            Alert::error(__('global.alerts.error'), $e);

            return back()
                ->withInput();
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => [
                'required',
                'min:6'
            ],
            'language'  => 'in:en,pt_BR',
            'theme' => 'in:Default,Default Dark,Mini Light,Mini Dark,Open Sidebar Light,Open Sidebar Dark,Hide Sidebar Light,Hide Sidebar Dark'
        ]);

        $newUser = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        activity()
            ->causedBy(Auth::user()->id)
            ->event('created')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'User';
                $activity->subject_type = 'App\Models\User';
                $activity->ip = $request->ip();
            })
            ->log('User ID: ' . $newUser->id . ' has been created');

        return back();
    }

    public function change_language(Request $request, $language)
    {
        $this->validate($request, [
            'language'  => 'in:en,pt_BR',
        ]);

        Auth::user()->update(['language' => $language]);

        Alert::success(__('global.alerts.success'), __('profile.alerts.language_updated'));
        return back();
    }

    public function active(Request $request)
    {
        $this->validate($request, [
            'status'  => 'in:0,1',
        ]);

        User::where('id', $request->id)->update(['status' => 1]);

        activity()
            ->causedBy(Auth::user()->id)
            ->event('activated')
            ->withProperties(['status' => 1])
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'User';
                $activity->subject_type = 'App\Models\User';
                $activity->ip = $request->ip();
            })
            ->log('User ID: ' . $request->id . ' has been activated');

        Alert::success(__('global.alerts.success'), __('users.alerts.user_activated'));
        return back()->withInput();
    }

    public function deactive(Request $request)
    {
        $this->validate($request, [
            'status'  => 'in:0,1',
        ]);

        User::where('id', $request->id)->update(['status' => 0]);

        activity()
            ->causedBy(Auth::user()->id)
            ->event('deactivated')
            ->withProperties(['status' => 0])
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'User';
                $activity->subject_type = 'App\Models\User';
                $activity->ip = $request->ip();
            })
            ->log('User ID: ' . $request->id . ' has been deactivated');

        Alert::success(__('global.alerts.success'), __('users.alerts.user_deactivated'));
        return back()->withInput();
    }

    public function lockscreen()
    {
        if (Auth::check()) {
            session(['lock-expires-at' => now()]);
            alert()->success(__('global.alerts.system_bloked'));
            return redirect()->route('login.locked');
        }
    }
}