<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Milestone;
use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\StudentRecord;
use App\Models\TimelineTemplate;
use App\Models\MilestoneTemplate;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\TimelineCopyRequest;
use App\Http\Requests\TimelineTemplateRequest;

class TimelineTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorise('manage', TimelineTemplate::class);

        if ($request->ajax())
        {
            $timeline = TimelineTemplate::select('timeline_templates.*')->withCount(['milestone_templates']);

            return Datatables::eloquent($timeline)
                ->addColumn('editaction', function (TimelineTemplate $tt) {
                    return '<form method="GET" action="' . route('admin.settings.timeline.edit',
                      $tt->id) . '" accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (TimelineTemplate $tt) {
                      return '<form method="POST" action="' . route('admin.settings.timeline.destroy',
                        $tt->id) . '" accept-charset="UTF-8" class="delete-form">
                      <input type="hidden" name="_method" value="DELETE">' . 
                      csrf_field() . '<button class="btn btn-danger">
                      <i class="fa fa-trash"></i></button> </form>';
                })
                ->rawColumns(['editaction', 'deleteaction'])
                ->setRowAttr([ 'data-link' => function($tt)
                    { return route('admin.settings.timeline.show', $tt->id); }])
                ->make(true);
        }

        $deleted_timelines = TimelineTemplate::onlyTrashed()->get();
        return view('admin.settings.timelinetemplate.index', compact('deleted_timelines'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimelineTemplateRequest $request)
    {

        $this->authorise('manage', TimelineTemplate::class);

        $tt = TimelineTemplate::create($request->only( 'name' ));
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', [
                'message' => 'Successfully added "' . $tt->name . '"',
                'type' => 'success'
            ]
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TimelineTemplate $timeline)
    {

        $this->authorise('manage', $timeline);

        if ($request->ajax())
        {
            $milestones = $timeline->milestone_templates()->select('milestone_templates.*');

            return Datatables::eloquent($milestones)
                ->addColumn('name', function (MilestoneTemplate $mt)
                    { return $mt->type->name; })
                ->addColumn('editaction', function (MilestoneTemplate $mt) use ($timeline) {
                    return '<form method="GET" action="' . 
                    route('admin.settings.timeline.milestone.edit', [$timeline->id, $mt->id]) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (MilestoneTemplate $mt) use ($timeline) {
                      return '<form method="POST" action="' . route('admin.settings.timeline.milestone.destroy', [$timeline->id, $mt->id]) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <input type="hidden" name="_method" value="DELETE">' .
                      csrf_field() . '<button class="btn btn-danger">
                      <i class="fa fa-trash"></i></button> </form>';
                })
                ->rawColumns(['editaction', 'deleteaction'])->make(true);
        }

        $deleted_milestones = $timeline->milestone_templates()->onlyTrashed()->get();
        $types = MilestoneType::all();
        return view('admin.settings.timelinetemplate.show',
            compact('timeline', 'types','deleted_milestones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(TimelineTemplateRequest $request, TimelineTemplate $timeline)
    {

        $this->authorise('manage', $timeline);
        
        $timeline->update($request->only('name'));
        $timeline->save();
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', [
                'message' => 'Successfully updated "' . $timeline->name . '"',
                'type' => 'success'
            ]);
    }

    public function edit(TimelineTemplate $timeline)
    {

        $this->authorise('manage', $timeline);

        // timeline update edit timeline name
        return view('admin.settings.timelinetemplate.edit', compact('timeline'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimelineTemplate  $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimelineTemplate $timeline)
    {

        $this->authorise('manage', $timeline);

        // We are using soft delete so this item will remain in the datase
        $timeline->delete();
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', [
                'message' => 'Successfully deleted "' . $timeline->name . '"',
                'type' => 'success'
            ]);
    }

    public function restore($id)
    {
        $tt = TimelineTemplate::withTrashed()->find($id);

        $this->authorise('manage', $tt);

        if($tt->trashed())
        {
            $tt->restore();
            return redirect()
                ->route('admin.settings.timeline.index')
                ->with('flash', [
                'message' => 'Successfully restored "' . $tt->name . '"',
                'type' => 'success'
            ]);
        }
        return redirect()
                ->route('admin.settings.timeline.index')
                ->with('flash', [
                'message' => 'Error: Timeline Template has not deleted: "' . $tt->name . '"',
                'type' => 'danger'
            ]);
    }

      public function create_mass_assignment(Student $student, StudentRecord $record)
      {

          $this->authorise('manage', $student);
          $this->authorise('manage', Milestone::class);
          $this->authorise('view', TimelineTemplate::class);

          $timelines = TimelineTemplate::all();
          return view('admin.user.student.mass_assignment',  compact('timelines','student', 'record'));
      }

      public function store_mass_assignment(TimelineCopyRequest $request,
        Student $student, StudentRecord $record)
      {

          $this->authorise('manage', $student);
          $this->authorise('manage', Milestone::class);
          $this->authorise('view', TimelineTemplate::class);

          $tt = TimelineTemplate::where('id', $request->timeline_id)->first();

          if($tt){
            $tt->copyToStudent($record);
            return redirect()->route('admin.student.record.show', 
              [$student->university_id, $record->slug()])
              ->with('flash', [
                'message' => 'Milestones in '.$tt->name.' successfully copied to '.$student->name.'\'s record',
                'type' => 'success'
            ]);
          }

          return redirect()->route('admin.student.record.show', 
            [$student->university_id, $record->slug()])
            ->with('flash', [
              'message' => 'Error: Something went wrong! please try again',
              'type' => 'danger'
            ]);
      }
}
