<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\Models\School;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\Programme;
use App\Models\FundingType;
use App\Models\ModeOfStudy;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Models\StudentStatus;
use App\Models\EnrolmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\FindStudentRequest;
use App\Http\Requests\StudentRecordRequest;
use App\Http\Requests\ConfirmStudentIdRequest;

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
                'school' => function ($query) { $query->withTrashed(); },
                'enrolmentStatus' => function ($query) { $query->withTrashed(); }
            ])->has('student');
            return Datatables::eloquent($students)
                ->addColumn('first_name', function (StudentRecord $sr)
                    { return $sr->student->first_name; })
                ->addColumn('school', function (StudentRecord $sr)
                    { return $sr->school->name; })
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
        $overdue = $student->record()->milestones->filter->isOverdue();
        $upcoming = $student->record()->milestones->filter->isUpcoming();
        return view('student.dashboard', compact('student', 'upcoming', 'overdue'));
    }

    public function find()
    {
        return view('admin.user.student.find');
    }

    public function find_post(FindStudentRequest $request)
    {

        $student = Student::where('university_id', $request->university_id)->first();
        if ($student)
        {
            session()->flash('student', $student);
            return redirect()->route('admin.student.confirm');
        }
        session()->flash('student_id', $request->university_id);
        return redirect()->route('admin.student.confirm_id');
    }

    public function confirm_user()
    {
        if( session()->has( 'student' ) )
        {
            session()->reflash();
            $student = session()->get( 'student' );
            return view( 'admin.user.student.found', compact( 'student' ) );
        }
        return redirect()->route('admin.student.find');
    }

    public function confirm_post_user(Request $request)
    {
        if( session()->has( 'student' ) )
        {
            session()->reflash();
            return redirect()->route( 'admin.student.create_record', session()->get('student')->university_id );
        }
        return redirect()->route( 'admin.student.find' );
    }

    public function confirm_id()
    {
        if( session()->has( 'student_id' ))
        {
            session()->reflash();
            return view( 'admin.user.student.notfound');
        }
        return redirect()->route('admin.student.find');
    }

    public function confirm_post_id(Request $request)
    {
        if( session()->has( 'student_id' ) )
        {
            if($request->university_id === session()->get('student_id'))
            {
                session()->reflash();
                return redirect()->route( 'admin.student.create', $request->student_id );
            }

            session()->reflash();
            redirect()->back()->withErrors(['student', 'WHAT IS THIS?']);
        }
        redirect()->back()->withErrors(['nomatch' =>'The IDs provided do not match. Please try again']);
        return redirect()->route( 'admin.student.find' );
    }

    public function create_record(Student $student)
    {
        if(session()->has( 'student' ) || session()->hasOldInput('student') )
        {
            $funding_types = FundingType::all();
            $schools = School::all();
            $enrolment_statuses = EnrolmentStatus::all();
            $student_statuses = StudentStatus::all();
            $modes_of_study = ModeOfStudy::all();
            $programmes = Programme::all();

            if( session()->get( 'student' )->id !== $student->id) abort(404);

            return view( 'admin.user.student.create_record', compact(
                'student', 'funding_types', 'schools',
                'enrolment_statuses', 'student_statuses',
                'modes_of_study', 'programmes' )
            );
        }
        return redirect()->route( 'admin.student.find' );
    }

    public function store_record(StudentRecordRequest $request, Student $student)
    {
        if ($request->university_id != $student->university_id) abort(404);

            $student->records->each->delete();

            $record = $student->records()
                ->save(StudentRecord::make([
                    'enrolment_date' => $request->enrolment_date,
                    'tierFour' => $request->tierFour,
                    'funding_type_id' => $request->funding_type_id,
                    'school_id' => $request->school_id,
                    'enrolment_status_id' => $request->enrolment_status_id,
                    'student_status_id' => $request->student_status_id,
                    'mode_of_study_id' => $request->mode_of_study_id,
                    'programme_id' => $request->programme_id,
            ])
        );
        return redirect()->route('admin.student.show', $student->university_id);
    }

    public function create()
    {
        if(session()->has( 'student_id' ) || session()->hasOldInput('university_id') )
        {
            $university_id = session()->get( 'student_id' );   
            return view( 'admin.user.student.create', compact('university_id') );
        }
        return redirect()->route( 'admin.student.find' );
    }

    public function store(StudentRequest $request)
    {
        $student = Student::firstOrCreate([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'university_id' => $request->university_id,
            'university_email' => $request->university_email,
        ]);
        
        session()->flash('student', $student);
        return redirect()->route('admin.student.confirm');
    }
}
