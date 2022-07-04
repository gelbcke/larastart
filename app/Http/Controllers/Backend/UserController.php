<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
        $this->middleware('permission:users-list');
        $this->middleware('permission:users-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:users-change-status', ['only' => ['active', 'deactive']]);
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

    /**
     * Create a new user
     *
     * @return void
     */
    public function create()
    {
        $roles = Role::latest()->get();
        return view('backend.user.create', compact('roles'));
    }

    /**
     * Edit user data
     *
     * @param User $user
     * @return void
     */
    public function edit(User $user)
    {
        $userRole = $user->roles->pluck('name')->toArray();
        $roles = Role::latest()->get();

        return view(
            'backend.user.edit',
            compact('user', 'userRole', 'roles')
        );
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Store a newly created user
     *
     * @param User $user
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            $user->syncRoles($request->get('role'));

            activity()
                ->causedBy(Auth::user()->id)
                ->event('created')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = 'User';
                    $activity->subject_type = 'App\Models\User';
                    $activity->ip = $request->ip();
                })
                ->log('User ID: ' . $user->id . ' has been created');

            Alert::success([__('global.alerts.success'), __('users.alerts.user_created')]);

            return redirect()->route('users.index');
        } catch (\Exception $e) {
            throw new ValidationException($e);

            Alert::error([__('global.alerts.error'), $e]);

            return back()
                ->withInput();
        }
    }

    /**
     * Active users can make login on system
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * User deactivated can't make login on system
     *
     * @param Request $request
     * @return void
     */
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

    /**
     * List all users
     *
     * @param Request $request
     * @return void
     */
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {

            $data = User::select(['id', 'name', 'email', 'phone', 'status', 'created_at'])->with('roles');

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    if ($row->status == 1) {
                        $status_btn = '<a href="' . route("users.deactive", $row->id) . '" title="' . __('global.form.deactivate') . '" class="fa-solid fa-user-xmark" style="color: #dc3545"></a>';
                    } else {
                        $status_btn = '<a href="' . route("users.active", $row->id) . '"  title="' . __('global.form.activate') . '" class="fa-solid fa-user-check" style="color: #1e7e34"></a>';
                    }

                    $btn = '
                    <a href="' . route("user.profile", $row->id) . '" class="fa-solid fa-eye" title="' . __('global.form.view') . '" style="color: #0069d9; margin-right: 5px"></a>
                    <a href="' . route("users.edit", $row->id) . '" class="fa-solid fa-pen-to-square" title="' . __('global.form.edit') . '" style="color: #0069d9; margin-right: 5px"></a>
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
                    return '<a href="' . route('user.profile', $user->id) . '">' . $user->name . '</a>  ';
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
}
