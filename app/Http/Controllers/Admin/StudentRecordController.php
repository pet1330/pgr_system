<?php

namespace App\Http\Controllers\Admin;

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

class StudentRecordController extends Controller
{
    public function create(Student $student)
    {
        $this->authorise('create', Student::class);

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

    public function edit(Student $student, StudentRecord $record)
    {
        $this->authorise('update', $record->student);

        if( $student->id !== $record->student_id) abort(404);

            $funding_types = FundingType::all();
            $schools = School::all();
            $enrolment_statuses = EnrolmentStatus::all();
            $student_statuses = StudentStatus::all();
            $modes_of_study = ModeOfStudy::all();
            $programmes = Programme::all();

            return view('admin.user.student.edit_record', compact(
                'student', 'record', 'funding_types', 'schools',
                'enrolment_statuses', 'student_statuses',
                'modes_of_study', 'programmes' )
            );
        return redirect()->route( 'admin.student.find' );
    }

    public function store(StudentRecordRequest $request, Student $student)
    {
        $this->authorise('create', $student);

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
        return redirect()->route('admin.student.show', $student->university_id)
            ->with('flash', [
              'message' => 'Successfully added a record for "' . $student->name . '"',
              'type' => 'success'
            ]);
    }

    public function update(StudentRecordRequest $request, Student $student, StudentRecord $record)
    {

        if( $student->id !== $record->student_id) abort(404);

        $this->authorise('update', $student);
        
        $record->update(
            $request->only([
                'enrolment_date',
                'tierFour',
                'funding_type_id',
                'school_id',
                'enrolment_status_id',
                'student_status_id',
                'mode_of_study_id',
                'programme_id'
            ])
        );
        
        $record->save();
    
        return redirect()
            ->route('admin.student.record.show', [$student->university_id, $record->slug()])
            ->with('flash', [
              'message' => 'Successfully updated "' . $record->slug() . '"',
              'type' => 'success'
            ]);
    }

    public function show(Student $student, StudentRecord $record)
    {

        if($student->id !== $record->student_id) abort(404);

        $this->authorise('view', $student);

        if($student->record() !== null)
        {
            $record = $student->record();
            $overdue = $record->timeline->filter->isOverdue();
            $upcoming = $record->timeline->filter->isUpcoming();
            return view('student.dashboard', compact('student', 'record', 'upcoming', 'overdue'));
        }

        return view('student.dashboard', compact('student'));
    }

    public function addSupervisor(SupervisorRequest $request, Student $student, StudentRecord $record)
    {
        $staff = Staff::where('university_id', $request->university_id);

        if($staff)
        {
            $record->addSupervisor($staff, $request->type);

            return redirect()->route('admin.student.record.show',
                [$student->university_id, $record->slug()])
                ->with('flash', [
                  'message' => $staff->name . ' is now supervising ' . $student->name,
                  'type' => 'success'
                ]);
        }

        return redirect()->route('admin.staff.find');
    }

    public function removeSupervisor(SupervisorRequest $request, Student $student, StudentRecord $record)
    {
        $staff = Staff::where('university_id', $request->university_id);

        if($staff)
        {
            $record->addSupervisor($staff, $request->type);

            return redirect()->route('admin.student.record.show',
                [$student->university_id, $record->slug()])
                ->with('flash', [
                  'message' => $staff->name . ' no longer supervises ' . $student->name,
                  'type' => 'success'
                ]);
        }

        return redirect()->route('admin.staff.find');
    }
}
