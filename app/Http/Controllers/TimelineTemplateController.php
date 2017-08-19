<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TimelineTemplate;
use App\Http\Controllers\Controller;

class TimelineTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // timeline index      list all timelines
        $templates = TimelineTemplate::withCount('milestone_templates')->get();
        return view('admin.settings.timelinetemplate.index', compact('templates'));
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
            ->route('admin.settings.timeline-template.index')
            ->with('flash', 'Successfully added "' . $tt->name . '"');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(TimelineTemplate $template)
    {
        // timeline show       list all milestones on a timeline
        return view('admin.settings.timelinetemplate.show', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimelineTemplate $template)
    {
        // timeline update     edit timeline name
        return "timeline";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimelineTemplate  $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimelineTemplate $template)
    {
        // timeline delete     delete a timeline (archive)
        // We are using soft delete so this item will remain in the datase    
        $template->delete();
        return redirect()
            ->route('admin.settings.timeline-template.index')
            ->with('flash', 'Successfully deleted "' . $template->name . '"');
    }
}
