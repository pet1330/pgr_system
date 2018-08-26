<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Milestone;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $this->authorise('view', Admin::class);

        if ($request->ajax()) {
            $admin = Admin::select('users.*');

            return Datatables::eloquent($admin)
            ->setRowAttr(['data-link' => function (Admin $admin) {
                return route('admin.show', $admin->university_id);
            }])
            ->make(true);
        }

        return View('admin.user.admin.index');
    }

    public function show(Admin $admin)
    {
        $this->authorise('view', $admin);

        $awaitingAmendments = Milestone::awaitingAmendments()->count();
        $overdue = Milestone::overdue()->count();
        $upcoming = Milestone::upcoming()->count();
        $recentlySubmitted = Milestone::recentlySubmitted()->count();

        return View('admin.dashboard',
            compact('admin', 'awaitingAmendments', 'overdue', 'upcoming', 'recentlySubmitted')
        );
    }

    public function downgrade(Request $request)
    {
        $this->authorise('manage', Admin::class);

        if ($request->ajax()) {
            $admin = Admin::select('users.*');

            return Datatables::eloquent($admin)
                ->addColumn('downgrade', function (Admin $admin) {
                    return '<form method="POST" action="'.route('admin.downgrade.store', $admin->university_id).'" accept-charset="UTF-8" class="success-form text-center">'.
                    csrf_field().'<button class="btn btn-default" onclick="return confirm(\'Are you sure?\')">
                    <i class="fa fa-user-times" aria-hidden="true"></i> Remove Admin Abilities</button> </form>';
                })->rawColumns(['downgrade'])->make(true);
        }

        return View('admin.settings.accesscontrol.downgrade');
    }

    public function downgrade_store(Request $request, Admin $admin)
    {
        $this->authorise('manage', Admin::class);

        $admin->user_type = 'Staff';
        $admin->save();
        $staff = Staff::find($admin->id);

        $staff->assignDefaultPermissions(true);

        return redirect()->route('admin.downgrade.index')
            ->with('flash', [
                'message' => $staff->name.' is no longer an Admin',
                'type' => 'success',
            ]);
    }
}
