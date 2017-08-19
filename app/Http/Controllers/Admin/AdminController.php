<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class AdminController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $students = Admin::select();
            return Datatables::eloquent($students)
            ->setRowAttr([ 'data-link' => function($admin)
                { return route('admin.admin.show', $admin->id); }])
            ->make(true);
        }
        return View('admin.index.admins');
    }
    public function show(Admin $admin)
    {
        return View('admin.dashboard', compact('admin'));
    }

    public function ownProfile()
    {
        return View('admin.profile');
    }
}
