<?php

namespace App\Http\Controllers\Admin;

use App\Models\Note;
use App\Models\School;
use App\Models\Absence;
use App\Models\Student;
use App\Models\Milestone;
use App\Models\Programme;
use App\Models\FundingType;
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
use Yajra\Datatables\Engines\EloquentEngine;

class StudentRecordController extends Controller
{
    public function create(Student $student)
    {
        $this->authorise('create', Student::class);

        if( session()->has( 'student' ) || session()->hasOldInput('university_id') )
        {

            $funding_types = FundingType::all();
            $schools = School::all();
            $enrolment_statuses = EnrolmentStatus::all();
            $student_statuses = StudentStatus::all();
            $programmes = Programme::all();

            return view( 'admin.user.student.create_record', compact(
                'student', 'funding_types', 'schools',
                'enrolment_statuses', 'student_statuses', 'programmes' )
            );
        }
        return redirect()->route( 'admin.student.find' );
    }

    public function edit(Student $student, StudentRecord $record)
    {

        if( $student->id !== $record->student_id ) abort(404);

        $this->authorise('update', $student);

            $funding_types = FundingType::all();
            $schools = School::all();
            $enrolment_statuses = EnrolmentStatus::all();
            $student_statuses = StudentStatus::all();
            $programmes = Programme::all();

            return view('admin.user.student.edit_record', compact(
                'student', 'record', 'funding_types', 'schools',
                'enrolment_statuses', 'student_statuses', 'programmes' )
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

    public function show(Request $request, Student $student, StudentRecord $record)
    {

        if($student->id !== $record->student_id) abort(404);

        $this->authorise('view', $student);

        if($request->ajax())
        {
            return $this->absences_controls(
                $this->absences($record), $student)->make(true);
        }

        if($student->record() !== null)
        {
            $record = $student->record();
            $overdue = $record->timeline->filter->isOverdue();
            $upcoming = $record->timeline->filter->isUpcoming();

            return view('student.dashboard', compact('student', 'record', 'upcoming', 'overdue'));
        }

        return view('student.dashboard', compact('student'));
    }

    private function absences_controls(EloquentEngine $dt, Student $student)
    {
        if( auth()->user()->can('delete', Absence::class) )
        {
            $dt->addColumn('deleteaction', function (Absence $abs) use ($student) {
              return '<form method="POST" action="' . route('admin.student.absence.destroy', [$student, $abs->slug()]) . '"
              accept-charset="UTF-8" class="delete-form">
              <input type="hidden" name="_method" value="DELETE">' .
              csrf_field() . '<button class="btn btn-danger">
              <i class="fa fa-trash"></i></button> </form>';
            })->rawColumns(['deleteaction']);
        }
        return $dt;
    }

    private function absences(StudentRecord $record)
    {

        $this->authorise('view', $record->student);

        $abs = $record->student->absences()->select('absences.*')->with([
            'type' => function ($query) { $query->withTrashed(); } ]);

        return Datatables::eloquent($abs)
            ->addColumn('type', function (Absence $ab) { return $ab->type->name; })
            ->editColumn('from', function (Absence $ab) { return $ab->from->format('d/m/Y'); })
            ->editColumn('to', function (Absence $ab) { return $ab->to->format('d/m/Y'); });
    }

    public function addSupervisor(SupervisorRequest $request, Student $student, StudentRecord $record)
    {

        $this->authorise('create', Staff::class);

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

        $this->authorise('create', Staff::class);

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

    public function note(Request $request, Student $student, StudentRecord $record)
    {

        $this->authorise('view', Note::class);

        $record->updateNote($request->content);
        return "Note Updated Successfully.";
    }
}
