<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absence;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AbsenceType;
use App\Http\Controllers\Controller;
use App\Http\Requests\AbsenceRequest;

class AbsenceController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {

        $this->authorise('manage', Absence::class);

        $types = AbsenceType::all();
        return view('admin.absence.create', compact('student', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsenceRequest $request, Student $student)
    {

        $this->authorise('manage', Absence::class);

        $absence = $student->absences()->save(
            Absence::make([
                'from' => $request->from,
                'to' => $request->to,
                'absence_type_id' => $request->absence_type_id,
                'duration' => $request->duration,
            ])
        );

        $student->records->each->recalculateMilestonesDueDate();
        return redirect()->route('student.show', $student->university_id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, Absence $absence)
    {
        
        $this->authorise('manage', $absence);

        $types = AbsenceType::all();
        return view('admin.absence.edit', compact('absence', 'student', 'types'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, Absence $absence)
    {
        $this->authorise('manage', $absence);
        $absence->delete();
        $student->records->each->recalculateMilestonesDueDate();
        return redirect()->route('student.show', $student->university_id);
    }
}
