<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:roles-list');
        $this->middleware('permission:roles-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('roles.index', compact('roles'));
        /*
        $roles = Role::orderBy('id', 'DESC')->paginate(5);

        return view('roles.index', compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
            */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        try {
            $role = Role::create(['name' => $request->get('name')]);
            $role->syncPermissions($request->get('permission'));

            activity()
                ->causedBy(Auth::user()->id)
                ->event('created')
                ->withProperties($request)
                ->tap(function (Activity $activity) use ($request) {
                    $activity->log_name = 'Role';
                    $activity->subject_type = 'App\Models\Role';
                    $activity->ip = $request->ip();
                })
                ->log('Role ' . $role->name . ' created!');

            Alert::success(__('global.alerts.success'), 'Role created successfully');

            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            Alert::warning('Error: ' . $e);
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions;

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Role $role, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role->update($request->only('name'));

        $role->syncPermissions($request->get('permission'));

        activity()
            ->causedBy(Auth::user()->id)
            ->event('updated')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Role';
                $activity->subject_type = 'App\Models\Role';
                $activity->ip = $request->ip();
            })
            ->log('Role ' . $role->name . ' was updated!');

        Alert::success(__('global.alerts.success'), 'Role updated successfully');

        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role, Request $request)
    {
        $role->delete();

        activity()
            ->causedBy(Auth::user()->id)
            ->event('deleted')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Role';
                $activity->subject_type = 'App\Models\Role';
                $activity->ip = $request->ip();
            })
            ->log('Role ' . $role->name . ' was deleted!');

        Alert::success(__('global.alerts.success'), 'Role deleted successfully!');

        return redirect()->route('roles.index');
    }
}
