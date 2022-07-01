<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Activitylog\Models\Activity;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:permissions-list');
        $this->middleware('permission:permissions-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permissions-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show form for creating permissions
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'string',
            'name' => 'required|unique:users,name'
        ]);

        $permission = Permission::create($request->only('name'));

        activity()
            ->causedBy(Auth::user()->id)
            ->event('created')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Permission';
                $activity->subject_type = 'App\Models\Permission';
                $activity->ip = $request->ip();
            })
            ->log('New permission ' . $permission->name . ' created!');

        Alert::success(__('global.alerts.success'), 'Permission ' . $permission->name . ' created successfully.');

        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id
        ]);

        $permission->update($request->only('name'));

        activity()
            ->causedBy(Auth::user()->id)
            ->event('updated')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Permission';
                $activity->subject_type = 'App\Models\Permission';
                $activity->ip = $request->ip();
            })
            ->log('Permission ' . $permission->name . ' was updated!');

        Alert::success(__('global.alerts.success'), 'Permission ' . $permission->name . ' updated successfully.');

        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission, Request $request)
    {
        $permission->delete();

        activity()
            ->causedBy(Auth::user()->id)
            ->event('deleted')
            ->withProperties($request)
            ->tap(function (Activity $activity) use ($request) {
                $activity->log_name = 'Permission';
                $activity->subject_type = 'App\Models\Permission';
                $activity->ip = $request->ip();
            })
            ->log('Permission ' . $permission->name . ' was deleted!');

        Alert::success(__('global.alerts.success'), 'Permission ' . $permission->name . ' deleted successfully.');

        return redirect()->route('permissions.index');
    }
}
