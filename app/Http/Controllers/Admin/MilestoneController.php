<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilestoneRequest;
use Yajra\Datatables\Facades\Datatables;

class MilestoneController extends Controller
{
    public function overdue(Request $request)
    {
        if ($request->ajax())
        {
            return $this->data( Milestone::overdue() )->make(true);
        }

        return view('admin.milestone.index', [
            'title' => 'Overdue Milestones',
            'subtitle' => 'All overdue milestones',
            ]);
    }

    public function upcoming(Request $request)
    {
        if ($request->ajax())
        {
            return $this->data( Milestone::upcoming() )->make(true);
        }

        return view('admin.milestone.index', [
            'title' => 'Upcoming Milestones',
            'subtitle' => 'All upcoming milestones',
            ]);
    }

    public function submitted(Request $request)
    {
        if ($request->ajax())
        {
            return $this->data( Milestone::submitted() )
                ->editColumn('submitted_date', function (Milestone $ms)
                { 
                    return $ms->submitted_date->format('d/m/Y') .
                           ' (' . $ms->submitted_date->diffForHumans() . ')';
                })
                ->filterColumn('submitted_date', function ($query, $keyword) {
                    $keyword = implode('%%',str_split(str_replace( ['+', '-'], '',
                        filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                    )));
                    $query->whereRaw("DATE_FORMAT(submitted_date,'%d/%m/%Y') like ?", ["%%$keyword%%"]);
                })
                ->make(true);
        }

        return view('admin.milestone.index', [
            'title' => 'Submitted Milestones',
            'subtitle' => 'All submitted milestones',
            'show_submitted' => true,
            ]);
    }

    public function data($milestones)
    {
        return Datatables::eloquent($milestones->with('milestone_type', 'student', 'student.student'))
            ->editColumn('milestone_type', function (Milestone $ms)
                { return $ms->name; })
            ->editColumn('due_date', function (Milestone $ms)
                { return $ms->due_date->format('d/m/Y') . '  ('.$ms->due_date->diffForHumans().')' ; })
            ->editColumn('first_name', function (Milestone $ms)
                { return $ms->student->student->first_name; })
            ->editColumn('last_name', function (Milestone $ms)
                { return $ms->student->student->last_name; })
            ->filterColumn('due_date', function ($query, $keyword) {
                $keyword = implode('%%',str_split(str_replace( ['+', '-'], '',
                    filter_var($keyword, FILTER_SANITIZE_NUMBER_INT)
                )));
                $query->whereRaw("DATE_FORMAT(due_date,'%d/%m/%Y') like ?", ["%%$keyword%%"]);
            })
            ->setRowAttr([ 'data-link' => function(Milestone $ms)
                { return route('admin.student.show', $ms->student->student->university_id); }]);
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StudentRecord $student)
    {
        $types = MilestoneType::all();
        return view('admin.milestone.create', compact('student', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MilestoneRequest $request, StudentRecord $student)
    {
        $away_days = $student->student->interuptionPeriodSoFar($request->due);
        $milestone = $student->timeline()->save(
            Milestone::make([
                'due_date' => $request->due,
                'milestone_type_id' => $request->milestone_type,
                'non_interuptive_date' => Carbon::parse($request->due)->subDays($away_days)
            ])
        );
        return redirect()->route('admin.student.milestone.show', compact('student', 'milestone'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(StudentRecord $student, Milestone $milestone)
    {
        if ($student->id != $milestone->student_record_id) abort(404);
        return view('admin.milestone.show', compact('student', 'milestone'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentRecord $student, Milestone $milestone)
    {
        if ($student->id != $milestone->student_record_id) abort(404);
        $types = MilestoneType::all();
        return view('admin.milestone.edit', compact('student', 'milestone', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MilestoneRequest $request, StudentRecord $student, Milestone $milestone)
    {
        if ($student->id != $milestone->student_record_id) abort(404);
        $away_days = $student->student->interuptionPeriodSoFar($request->due);
        $milestone->due_date = $request->due;
        $milestone->milestone_type_id = $request->milestone_type;
        $milestone->non_interuptive_date = Carbon::parse($request->due)->subDays($away_days);
        $milestone->save();
        return redirect()->route('admin.student.milestone.show', compact('student', 'milestone'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
