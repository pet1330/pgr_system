<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $this->authorise('view', Admin::class);

        if ($request->ajax())
        {
            $admin = Admin::select('users.*');
            return Datatables::eloquent($admin)
            ->setRowAttr([ 'data-link' => function(Admin $admin)
                { return route('admin.admin.show', $admin->university_id); }])
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
}
