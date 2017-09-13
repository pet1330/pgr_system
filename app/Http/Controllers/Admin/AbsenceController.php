<?php

namespace App\Http\Controllers\Admin;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Student $student)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Student $student)
    {

        $this->authorise('create', Absence::class);

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

        $this->authorise('create', Absence::class);

        $absence = $student->absences()->save(
            Absence::make([
                'from' => $request->from,
                'to' => $request->to,
                'absence_type_id' => $request->absence_type_id,
                'duration' => $request->duration,
            ])
        );

        $student->records->each->recalculateMilestonesDueDate();
        return redirect()->route('admin.student.show', $student->university_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student, Absence $absence)
    {
        $this->authorise('view', $absence);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student, Absence $absence)
    {
        
        $this->authorise('update', $absence);

        $types = AbsenceType::all();
        return view('admin.absence.edit', compact('absence', 'student', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AbsenceRequest $request, Student $student, Absence $absence)
    {
        
        $this->authorise('update', $absence);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student, Absence $absence)
    {
        $this->authorise('delete', $absence);
    }
}