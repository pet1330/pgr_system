<?php

namespace App\Http\Controllers;

use DB;
use DataTables;
use App\Models\Admin;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Requests\StaffRequest;
use App\Http\Requests\FindStaffRequest;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $this->authorise('view', Staff::class);

        if ($request->ajax()) {
            return Datatables::eloquent(Staff::select('users.*'))
                ->rawColumns(['editaction', 'deleteaction'])
            ->setRowAttr(['data-link' => function (Staff $staff) {
                return route('staff.show', $staff->university_id);
            }])
            ->make(true);
        }

        return View('admin.user.staff.index');
    }

    public function show(Staff $staff)
    {
        $this->authorise('view', $staff);

        $supervisees = $staff->supervising()->with('timeline')
            ->orderBy('supervisors.supervisor_type')
            ->withCount([
                'timeline AS overdue' => function ($query) {
                    $query->overdue();
                },
                'timeline AS upcoming' => function ($query) {
                    $query->upcoming();
                },
                'timeline AS amendments' => function ($query) {
                    $query->AwaitingAmendments(DB::raw('count(*) as amendments_count'));
                },
            ])->get()->groupBy('pivot.supervisor_type');

        return View('admin.user.staff.show', compact('staff', 'supervisees'));
    }

    public function find()
    {
        $this->authorise('manage', Staff::class);

        return view('admin.user.staff.find');
    }

    public function find_post(FindStaffRequest $request)
    {
        $this->authorise('manage', Staff::class);

        $staff = Staff::where('university_id', $request->university_id)->first();
        if ($staff) {
            session()->flash('staff', $staff);

            return redirect()->route('staff.show', $staff->university_id);
        }
        session()->flash('staff_id', $request->university_id);

        return redirect()->route('staff.confirm_id');
    }

    public function confirm_id()
    {
        $this->authorise('manage', Staff::class);

        if (session()->has('staff_id')) {
            session()->reflash();

            return view('admin.user.staff.notfound');
        }

        return redirect()->route('staff.find');
    }

    public function confirm_post_id(Request $request)
    {
        $this->authorise('manage', Staff::class);

        if (session()->has('staff_id')) {
            if ($request->university_id === session()->get('staff_id')) {
                session()->reflash();

                return redirect()->route('staff.create', $request->staff_id);
            }

            session()->reflash();
            redirect()->back()->withErrors(['staff', 'WHAT IS THIS?']);
        }
        redirect()->back()->withErrors(['nomatch' =>'The IDs provided do not match. Please try again']);

        return redirect()->route('staff.find');
    }

    public function create()
    {
        $this->authorise('manage', Staff::class);

        if (session()->has('staff_id') || session()->hasOldInput('university_id')) {
            $university_id = session()->get('staff_id');

            return view('admin.user.staff.create', compact('university_id'));
        }

        return redirect()->route('staff.find');
    }

    public function store(StaffRequest $request)
    {
        $this->authorise('manage', Staff::class);

        $staff = Staff::firstOrCreate([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'university_id' => $request->university_id,
                'university_email' => $request->university_email,
                'user_type' => 'Staff',
            ]);

        $staff->assignDefaultPermissions();

        session()->flash('staff', $staff);

        return redirect()->route('staff.show', $staff->university_id)
            ->with('flash', [
                'message' => 'Successfully added "'.$staff->name.'"',
                'type' => 'success',
            ]);
    }

    public function upgrade(Request $request)
    {
        $this->authorise('manage', Admin::class);

        if ($request->ajax()) {
            $staff = Staff::select('users.*')->doesntHave('supervising');

            return Datatables::eloquent($staff)
                ->addColumn('upgrade', function (Staff $staff) {
                    return '<form method="POST" action="'.route('staff.upgrade.store', $staff->university_id).'" accept-charset="UTF-8" class="success-form text-center">'.
                    csrf_field().'<button class="btn btn-default" onclick="return confirm(\'Are you sure?\')">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Make Admin</button> </form>';
                })
                ->rawColumns(['upgrade'])
                ->make(true);
        }

        return View('admin.settings.accesscontrol.upgrade');
    }

    public function upgrade_store(Request $request, Staff $staff)
    {
        $this->authorise('manage', Admin::class);

        $staff->user_type = 'Admin';
        $staff->save();
        $admin = Admin::find($staff->id);

        $admin->assignDefaultPermissions(true);

        return redirect()->route('staff.upgrade.index')
            ->with('flash', [
                'message' => $admin->name.' has been upgraded to an Admin',
                'type' => 'success',
            ]);
    }
}
