<?php

namespace App\Http\Controllers\Admin;

use App\Models\Student;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $students = StudentRecord::with([
                'student',
                'fundingType' => function ($query) { $query->withTrashed(); },
                'modeOfStudy' => function ($query) { $query->withTrashed(); },
                'studentStatus' => function ($query) { $query->withTrashed(); },
                'programme' => function ($query) { $query->withTrashed(); },
                'enrolmentStatus' => function ($query) { $query->withTrashed(); }
            ])->has('student');
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
                    { return route('admin.student.show', $student->student->university_id); }])
                ->make(true);
        }
        return View('admin.user.student.index');
    }

    public function show(Student $student)
    {
        $milestones = $student->record()->timeline;

        $recently_submitted = $milestones->filter->isRecentlySubmitted();
        $overdue = $milestones->filter->isOverdue();
        $submitted = $milestones->filter->isPreviouslySubmitted();
        $upcoming = $milestones->filter->isUpcoming();
        $future = $milestones->filter->isFuture();

        return View('student.dashboard', 
                        compact('student', 'milestones', 'recently_submitted',
                                'overdue', 'submitted', 'upcoming', 'future'));
    }

    public function create()
    {
        return view('admin.user.student.create');
    }
}
