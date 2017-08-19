<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $students = StudentRecord::with([
                'student', 'fundingType', 'modeOfStudy',
                'studentStatus', 'programme', 'enrolmentStatus',
            ]);
            return Datatables::eloquent($students)
                ->addColumn('first_name', function (StudentRecord $sr)
                    { return $sr->student->first_name; })
                ->addColumn('last_name', function (StudentRecord $sr)
                    { return $sr->student->last_name; })
                ->addColumn('university_id', function (StudentRecord $sr)
                    { return $sr->student->university_id; })
                ->addColumn('fundingType', function (StudentRecord $sr)
                    { return $sr->fundingType->name; })
                ->addColumn('modeOfStudy', function (StudentRecord $sr)
                    { return $sr->modeOfStudy->name; })
                ->addColumn('studentStatus', function (StudentRecord $sr)
                    { return $sr->studentStatus->status; })
                ->addColumn('programme', function (StudentRecord $sr)
                    { return $sr->programme->name; })
                ->addColumn('enrolmentStatus', function (StudentRecord $sr)
                    { return $sr->enrolmentStatus->status; })
                ->editColumn('tierFour', '{{$tierFour ? "Yes" : "No" }}')
                ->setRowAttr([ 'data-link' => function($student)
                    { return route('admin.student.show', $student->id); }])
                ->make(true);
        }
        return View('admin.index.students');
    }

    public function show(Student $student )
    {
        return View('student.dashboard', compact('student'));
    }

    public function ownProfile()
    {
        $student = App\Models\Student::first();
        return View('student.profile', compact('student'));
    }
}
