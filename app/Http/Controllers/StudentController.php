<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\School;
use App\Models\Student;
use App\Models\Programme;
use App\Models\FundingType;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Models\StudentStatus;
use App\Models\EnrolmentStatus;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\FindStudentRequest;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $this->authorise('view', Student::class);

        if ($request->ajax()) {
            $records = StudentRecord::select('student_records.*')->with([
                'student',
                'fundingType' => function ($query) {
                    $query->withTrashed();
                },
                'studentStatus' => function ($query) {
                    $query->withTrashed();
                },
                'programme' => function ($query) {
                    $query->withTrashed();
                },
                'school' => function ($query) {
                    $query->withTrashed();
                },
                'enrolmentStatus' => function ($query) {
                    $query->withTrashed();
                },
            ])->has('student');

            return Datatables::eloquent($records)
                ->addColumn('first_name', function (StudentRecord $sr) {
                    return $sr->student->first_name;
                })
                ->addColumn('school', function (StudentRecord $sr) {
                    return $sr->school->name;
                })
                ->addColumn('last_name', function (StudentRecord $sr) {
                    return $sr->student->last_name;
                })
                ->addColumn('university_id', function (StudentRecord $sr) {
                    return $sr->student->university_id;
                })
                ->addColumn('fundingType', function (StudentRecord $sr) {
                    return $sr->fundingType->name;
                })
                ->addColumn('studentStatus', function (StudentRecord $sr) {
                    return $sr->studentStatus->status;
                })
                ->addColumn('programme', function (StudentRecord $sr) {
                    return $sr->programme->name;
                })
                ->addColumn('enrolmentStatus', function (StudentRecord $sr) {
                    return $sr->enrolmentStatus->status;
                })
                ->editColumn('tierFour', '{{$tierFour ? "Yes" : "No" }}')
                ->setRowAttr(['data-link' => function (StudentRecord $sr) {
                    return route('student.show', $sr->student->university_id);
                }])->make(true);
        }

        return View('admin.user.student.index');
    }

    public function show(Student $student)
    {
        $this->authorise('view', $student);

        $current_records = $student->records()->count();

        if ($current_records === 0) {
            return view('student.no_record_dashboard', compact('student'));
        }

        if ($current_records > 1) {
            return view('student.show', compact('student'));
        }

        $old_records = $student->records()->onlyTrashed()->count();

        if ($old_records > 0) {
            if (auth()->user()->can('manage', Student::class)) {
                return view('student.show', compact('student'));
            }
        }

        session()->reflash();

        return redirect()->route('student.record.show',
            [$student->university_id, $student->record()->slug()]);

        dd($student->records()->withTrashed()->pluck('deleted_at'));

        dd('CASE NOT FOUND');
    }

    public function find()
    {
        $this->authorise('manage', Student::class);

        return view('admin.user.student.find');
    }

    public function find_post(FindStudentRequest $request)
    {
        $this->authorise('manage', Student::class);

        $student = Student::where('university_id', $request->university_id)->first();
        if ($student) {
            session()->flash('student', $student);

            return redirect()->route('student.confirm');
        }
        session()->flash('student_id', $request->university_id);

        return redirect()->route('student.confirm_id');
    }

    public function confirm_user()
    {
        $this->authorise('manage', Student::class);

        if (session()->has('student')) {
            session()->reflash();
            $student = session()->get('student');

            return view('admin.user.student.found', compact('student'));
        }

        return redirect()->route('student.find');
    }

    public function confirm_post_user(Request $request)
    {
        $this->authorise('manage', Student::class);

        if (session()->has('student')) {
            session()->reflash();

            return redirect()->route('student.record.create',
                session()->get('student')->university_id);
        }

        return redirect()->route('student.find');
    }

    public function confirm_id()
    {
        $this->authorise('manage', Student::class);

        if (session()->has('student_id')) {
            session()->reflash();

            return view('admin.user.student.notfound');
        }

        return redirect()->route('student.find');
    }

    public function confirm_post_id(Request $request)
    {
        $this->authorise('manage', Student::class);

        if (session()->has('student_id')) {
            if ($request->university_id === session()->get('student_id')) {
                session()->reflash();

                return redirect()->route('student.create', $request->student_id);
            }

            session()->reflash();
            redirect()->back()->withErrors(['student', 'WHAT IS THIS?']);
        }
        redirect()->back()->withErrors(['nomatch' =>'The IDs provided do not match. Please try again']);

        return redirect()->route('student.find');
    }

    public function create()
    {
        $this->authorise('manage', Student::class);

        if (session()->has('student_id') || session()->hasOldInput('university_id')) {
            $university_id = session()->get('student_id');

            return view('admin.user.student.create', compact('university_id'));
        }

        return redirect()->route('student.find');
    }

    public function store(StudentRequest $request)
    {
        $this->authorise('manage', Student::class);

        $student = Student::firstOrCreate([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'university_id' => $request->university_id,
            'university_email' => $request->university_email,
            'user_type' => 'Student',
        ]);

        $student->assignDefaultPermissions();

        session()->flash('student', $student);

        return redirect()->route('student.confirm')
            ->with('flash', [
                'message' => 'Successfully added "'.$student->name.'"',
                'type' => 'success',
            ]);
    }
}
