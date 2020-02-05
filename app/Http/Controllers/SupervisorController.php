<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindStaffRequest;
use App\Http\Requests\SupervisorRequest;
use App\Models\Staff;
use App\Models\Student;
use App\Models\StudentRecord;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function find(Student $student, StudentRecord $record)
    {
        $this->authorise('manage', Staff::class);

        return view('supervisor.find', compact('student', 'record'));
    }

    public function find_post(FindStaffRequest $request, Student $student, StudentRecord $record)
    {
        $this->authorise('manage', Staff::class);

        $staff = Staff::where('university_id', $request->university_id)->first();

        if ($staff) {
            return redirect()->route('supervisor.create',
                [$student->university_id, $record->slug(), $staff->university_id]);
        }
        session()->flash('staff_id', $request->university_id);

        return redirect()->route('supervisor.confirm_id',
            [$student->university_id, $record->slug()]);
    }

    public function create(Student $student, StudentRecord $record, Staff $staff)
    {
        $this->authorise('manage', Staff::class);

        return view('supervisor.found', compact('staff', 'student', 'record'));
    }

    public function store(SupervisorRequest $request, Student $student, StudentRecord $record)
    {
        $this->authorise('manage', Staff::class);

        $staff = Staff::where('university_id', $request->supervisor)->first();

        if ($student->id !== $record->student_id ||
            $staff->university_id !== $request->supervisor) {
            abort(404);
        }

        $record->addSupervisor($staff, $request->type);

        return redirect()->route('student.record.show',
                [$student->university_id, $record->slug()])
            ->with('flash', [
                'message' => $staff->name.' now supervises '.$student->name,
                'type' => 'success',
            ]);
    }

    public function confirm_id(Student $student, StudentRecord $record)
    {
        $this->authorise('manage', Staff::class);

        if (session()->has('staff_id')) {
            session()->reflash();

            return view('supervisor.notfound', compact('student', 'record'));
        }

        return redirect()->route('supervisor.find', [$student->university_id, $record->slug()]);
    }

    public function confirm_post_id(Request $request, Student $student, Staff $staff)
    {
        $this->authorise('manage', Staff::class);

        if (session()->has('staff_id')) {
            if ($request->university_id === session()->get('student_id')) {
                session()->reflash();

                return redirect()->route('staff.create', $request->student_id);
            }
        }
        redirect()->back()->withErrors(['nomatch' =>'The IDs provided do not match. Please try again']);

        return redirect()->route('student.find');
    }

    public function destroy(Request $request,
        Student $student, StudentRecord $record, Staff $staff)
    {
        $this->authorise('manage', $student);
        $this->authorise('manage', Staff::class);

        if ($student->id !== $record->student_id &&
            ! $record->supervisors()->pluck('id')
            ->contains($staff->id)) {
            abort(404);
        }

        $record->removeSupervisor($staff);

        return redirect()->route('student.record.show',
            [$student->university_id, $record->slug()]);
    }
}
