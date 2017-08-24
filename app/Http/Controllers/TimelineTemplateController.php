<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\MilestoneTemplate;
use App\Models\TimelineTemplate;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
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
        if ($request->ajax())
        {
            $timeline = TimelineTemplate::withCount(['milestone_templates'])->orderBy('name');

            return Datatables::eloquent($timeline)
                ->addColumn('editaction', function (TimelineTemplate $tt) {
                    return '<form method="GET" action="' . route('admin.settings.timeline.edit', $tt->id) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (TimelineTemplate $tt) {
                      return '<form method="POST" action="' . route('admin.settings.timeline.destroy', $tt->id) . '"
                      accept-charset="UTF-8" class="delete-form">
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
        // $templates = TimelineTemplate::withCount('milestone_templates')->get();
        // return view('admin.settings.timeline.index', compact('templates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimelineTemplateRequest $request)
    {
        $tt = TimelineTemplate::create($request->all());
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', 'Successfully added "' . $tt->name . '"');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, TimelineTemplate $timeline)
    {
        if ($request->ajax())
        {
            $milestones = $timeline->milestone_templates();

            return Datatables::eloquent($milestones)
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
                ->rawColumns(['editaction', 'deleteaction'])
                // ->setRowAttr([ 'data-link' => function($mt) use ($timeline)
                //     { return route('admin.settings.timeline.milestone.show', [$timeline->id, $mt->id]); }])
                ->make(true);
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
        // timeline update edit timeline name
        $timeline->update($request->only('name'));
        $timeline->save();
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', 'Successfully updated "' . $timeline->name . '"');
    }

    public function edit(TimelineTemplate $timeline)
    {
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
        // timeline delete     delete a timeline (archive)
        // We are using soft delete so this item will remain in the datase    
        $timeline->delete();
        return redirect()
            ->route('admin.settings.timeline.index')
            ->with('flash', 'Successfully deleted "' . $timeline->name . '"');
    }
}
