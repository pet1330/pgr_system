<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\UpdateRolesRequest;
use DataTables;
use Illuminate\Http\Request;
use Silber\Bouncer\Database\Ability;
use Silber\Bouncer\Database\Role;

class RolePermissionsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorise('view', Role::class);

        if ($request->ajax()) {
            $roles = Role::with('abilities');

            return Datatables::eloquent($roles)
                    ->addColumn('name', function (Role $role) {
                        return $role->name;
                    })
                    ->addColumn('abilities', function (Role $role) {
                        return $role->abilities->pluck('name')->implode('<br>');
                    })
                    ->addColumn('editaction', function (Role $role) {
                        return '<form method="GET" action=""
                      accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                    })
                    // ->setRowAttr([ 'data-link' => function(Role $role)
                    //     { return route('student.record.show',
                    //         [ $role->student->university_id, $role->slug()]); }])
                    ->rawColumns(['editaction', 'abilities'])
                    ->make(true);
        }

        $abilities = Ability::all();

        return view('admin.settings.rolepermissions.index', compact('abilities'));
    }

    public function store(RolesRequest $request, Role $role)
    {
        $this->authorise('create', Role::class);

        Bouncer::allow($role)->to($request->name, $request->model);
        $role->allow($request->input('abilities'));

        return redirect()->route('settings.rolepermissions.index');
    }

    /**
     * Show the form for editing Role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $abilities = Ability::get()->pluck('name', 'name');

        $role = Role::findOrFail($id);

        return view('admin.settings.rolepermissions.edit', compact('role', 'abilities'));
    }

    /**
     * Update Role in storage.
     *
     * @param  \App\Http\Requests\UpdateRolesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRolesRequest $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        foreach ($role->getAbilities() as $ability) {
            $role->disallow($ability->name);
        }
        $role->allow($request->input('abilities'));

        return redirect()->route('settings.rolepermissions.index');
    }

    /**
     * Remove Role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('settings.rolepermissions.index');
    }
}
