<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests\FindStaffRequest;
use App\Http\Requests\SupervisorRequest;

class SupervisorController extends Controller
{

    public function find(Student $student, StudentRecord $record)
    {

        $this->authorise('create', Staff::class);

        return view('supervisor.find', compact('student', 'record'));
    }

    public function find_post(FindStaffRequest $request, Student $student, StudentRecord $record)
    {

        $this->authorise('create', Staff::class);

        $staff = Staff::where('university_id', $request->university_id)->first();

        if ($staff)
        {
            return redirect()->route('admin.student.record.supervisor.create',
                [$student->university_id, $record->slug(), $staff->university_id]);
        }
        session()->flash('staff_id', $request->university_id);
        return redirect()->route('admin.student.record.supervisor.confirm_id', 
            [$student->university_id, $record->slug()]);
    }

    public function create(Student $student, StudentRecord $record, Staff $staff)
    {

        $this->authorise('create', Staff::class);

        return view( 'supervisor.found', compact( 'staff', 'student', 'record' ) );
    }

    public function store(SupervisorRequest $request, 
        Student $student, StudentRecord $record, Staff $staff)
    {

        $this->authorise('create', Staff::class);

        if($student->id !== $record->student_id ||
            $staff->university_id !== $request->supervisor) abort(404);

            $record->addSupervisor($staff, $request->type);
            return redirect()->route('admin.student.record.show',
                [$student->university_id, $record->slug()])
            ->with('flash', [
                'message' => $staff->name . ' is now a supervisor of ' . $student->name . '"',
                'type' => 'success'
            ]);
        return redirect()->route( 'admin.student.find' );
    }

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

    // public function create(Student $student, StudentRecord $record)
    // {
    //     $this->authorise('update', $student);
    //     $this->authorise('update', Staff::class);
    //     $staff = Staff::all();
    //     return view('student.add_supervisor', compact('student','record'));
    // }

    // public function store(SupervisorRequest $request,
    //     Student $student, StudentRecord $record)
    // {

    //     $this->authorise('update', $student);
    //     $this->authorise('create', Staff::class);

    //     if( $student->id !== $record->student_id ) abort(404);

    //     if ($staff = Staff::where('university_id', $request->staff_id)->first() )
    //     {
    //         $record->addSupervisor($staff, $request->type);
    //         return redirect()->route('student.record.show', 
    //             [$student->university_id, $record->slug()]);
    //     }
    //     abort(404);
    // }

    public function destroy(Request $request, 
        Student $student, StudentRecord $record, Staff $staff)
    {

        $this->authorise('update', $student);
        $this->authorise('create', Staff::class);

        if( $student->id === $record->student_id )
        {
            if( $record->supervisors()->pluck('id')->contains($staff->id) )
            {
                    $record->removeSupervisor($staff);
                    return redirect()->route('admin.student.record.show',
                        [$student->university_id, $record->slug()]);
            }
        }
        abort(404);
    }
}
