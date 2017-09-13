<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Silber\Bouncer\Database\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUsersRequest;
use App\Http\Requests\Admin\UpdateUsersRequest;

class UserRolesController extends Controller
{
    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->with('roles');

        dd($users->first()->roles);

        return view('admin.settings.userroles.index', compact('users'));
    }

    /**
     * Show the form for creating new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $roles = Role::get()->pluck('name', 'name');

        return view('admin.settings.userroles.create', compact('roles'));
    }

    /**
     * Store a newly created User in storage.
     *
     * @param  \App\Http\Requests\StoreUsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRolesRequest $request)
    {
        $user = User::create($request->all());

        foreach ($request->input('roles') as $role)
        {
            $user->assign($role);
        }

        return redirect()->route('admin.settings.userroles.index');
    }

    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.settings.userroles.edit', compact('user', 'roles'));
    }

    /**
     * Update User in storage.
     *
     * @param  \App\Http\Requests\UpdateUsersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        foreach ($user->roles as $role) {
            $user->retract($role);
        }
        foreach ($request->input('roles') as $role) {
            $user->assign($role);
        }

        return redirect()->route('admin.settings.userroles.index');
    }

    /**
     * Remove User from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.settings.userroles.index');
    }
}
