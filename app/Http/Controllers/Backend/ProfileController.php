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
use App\Traits\UploadTrait;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class ProfileController extends Controller
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
        $this->middleware('permission:profiles-view-all', ['only' => ['user_profile']]);
        $this->middleware('permission:profiles-view-own', ['only' => ['my_profile']]);
        $this->middleware('permission:profiles-edit-all', ['only' => ['update_user_profile']]);
        $this->middleware('permission:profiles-edit-own', ['only' => ['update_my_profile']]);
    }

    /**
     * Show auth user profile
     *
     * @return void
     */
    public function my_profile()
    {
        $languages = ([
            "en" => 'en',
            "pt_BR" => 'pt_BR'
        ]);

        $user = Auth::user();

        return view('backend.user.profile.my_profile', compact('user', 'languages'));
    }

    /**
     * Show profile of selected user
     *
     * @param User $user
     * @return void
     */
    public function user_profile(User $user)
    {
        $languages = ([
            "en" => 'en',
            "pt_BR" => 'pt_BR'
        ]);

        return view('backend.user.profile.user_profile', compact('user', 'languages'));
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update_user_profile(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->withSuccess(__('User updated successfully.'));
    }

    /**
     * Update auth user profile
     *
     * @param Request $request
     * @return void
     */
    public function update_my_profile(Request $request)
    {
        $this->validate($request, [
            'language'  => 'in:en,pt_BR',
            'theme' => 'in:Default,Default Dark,Big Light,Big Dark,Open Sidebar Light,Open Sidebar Dark,Hide Sidebar Light,Hide Sidebar Dark'
        ]);

        try {
            $user = Auth::user();
            $user->update($request->except(['role']));

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

            Alert::success([__('global.alerts.success'), __('profile.alerts.profile_updated')]);

            return back();
        } catch (\Exception $e) {
            throw new ValidationException($e);

            Alert::error([__('global.alerts.error'), $e]);

            return back()
                ->withInput();
        }
    }

    /**
     * Change language of auth user
     *
     * @param Request $request
     * @param [type] $language
     * @return void
     */
    public function change_language(Request $request, $language)
    {
        $this->validate($request, [
            'language'  => 'in:en,pt_BR',
        ]);

        Auth::user()->update(['language' => $language]);

        Alert::success(__('global.alerts.success'), __('profile.alerts.language_updated'));
        return back();
    }

    /**
     * Will lock auth session
     *
     * @return void
     */
    public function lockscreen()
    {
        if (Auth::check()) {
            session(['lock-expires-at' => now()]);
            alert()->success(__('global.alerts.system_bloked'));
            return redirect()->route('login.locked');
        }
    }
}
