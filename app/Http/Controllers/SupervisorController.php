<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupervisorRequest;

class SupervisorController extends Controller
{


    // public function find()
    // {

    //     $this->authorise('create', Staff::class);

    //     return view('admin.user.student.find');
    // }

    // public function find_post(FindStudentRequest $request)
    // {

    //     $this->authorise('create', Student::class);

    //     $student = Student::where('university_id', $request->university_id)->first();
    //     if ($student)
    //     {
    //         session()->flash('student', $student);
    //         return redirect()->route('admin.student.confirm');
    //     }
    //     session()->flash('student_id', $request->university_id);
    //     return redirect()->route('admin.student.confirm_id');
    // }

    // public function confirm_user()
    // {

    //     $this->authorise('create', Student::class);

    //     if( session()->has( 'student' ) )
    //     {
    //         session()->reflash();
    //         $student = session()->get( 'student' );
    //         return view( 'admin.user.student.found', compact( 'student' ) );
    //     }
    //     return redirect()->route('admin.student.find');
    // }

    // public function confirm_post_user(Request $request)
    // {

    //     $this->authorise('create', Student::class);

    //     if( session()->has( 'student' ) )
    //     {
    //         session()->reflash();
    //         return redirect()->route( 'admin.student.record.create', session()->get('student')->university_id );
    //     }
    //     return redirect()->route( 'admin.student.find' );
    // }

    // public function confirm_id()
    // {

    //     $this->authorise('create', Student::class);

    //     if( session()->has( 'student_id' ))
    //     {
    //         session()->reflash();
    //         return view( 'admin.user.student.notfound');
    //     }
    //     return redirect()->route('admin.student.find');
    // }

    // public function confirm_post_id(Request $request)
    // {

    //     $this->authorise('create', Student::class);

    //     if( session()->has( 'student_id' ) )
    //     {
    //         if($request->university_id === session()->get('student_id'))
    //         {
    //             session()->reflash();
    //             return redirect()->route( 'admin.student.create', $request->student_id );
    //         }

    //         session()->reflash();
    //         redirect()->back()->withErrors(['student', 'WHAT IS THIS?']);
    //     }
    //     redirect()->back()->withErrors(['nomatch' =>'The IDs provided do not match. Please try again']);
    //     return redirect()->route( 'admin.student.find' );
    // }












// -------------------------------------------------------------------------------------------

    public function create(Student $student, StudentRecord $record)
    {
        $this->authorise('update', $student);
        $this->authorise('update', Staff::class);
        $staff = Staff::all();
        return view('student.add_supervisor', compact('student','record'));
    }

    public function store(SupervisorRequest $request,
        Student $student, StudentRecord $record)
    {

        $this->authorise('update', $student);
        $this->authorise('create', Staff::class);

        if( $student->id !== $record->student_id ) abort(404);

        if ($staff = Staff::where('university_id', $request->staff_id)->first() )
        {
            $record->addSupervisor($staff, $request->type);
            return redirect()->route('student.record.show', 
                [$student->university_id, $record->slug()]);
        }
        abort(404);
    }

    public function delete(SupervisorRequest $request, 
        Student $student, StudentRecord $record)
    {

        $this->authorise('update', $student);
        $this->authorise('create', Staff::class);

        if( $student->id === $record->student_id &&
            $staff = Staff::where('university_id', $request->staff_id)->first() &&
            $record->supervisors()->pluck('id')->contains($staff->id) ){

                $record->removeSupervisor($staff);
                return redirect()->route('student.record.show', 
                    [$student->university_id, $record->slug()]);
            }
        abort(404);
    }
}
