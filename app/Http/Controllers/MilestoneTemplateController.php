<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Models\TimelineTemplate;
use App\Models\MilestoneTemplate;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilestoneTemplateRequest;

class MilestoneTemplateController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TimelineTemplate $timeline)
    {
        $types = MilestoneType::all();
        return view('admin.settings.milestonetemplate.create', compact('timeline', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MilestoneTemplateRequest $request, TimelineTemplate $timeline)
    {
        $milestone = $timeline->milestone_templates()->save(
            MilestoneTemplate::make([
                'due' => $request->due,
                'milestone_type_id' => $request->milestone_type
            ])
        );
        return redirect()
            ->route('admin.settings.timeline.show', $timeline->id)
            ->with('flash', 'Successfully added "' . $milestone->name . '"');
    }

    public function edit(TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        return view('admin.settings.milestonetemplate.edit', compact('timeline', 'milestone'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        dd("HERE");
        // milestone edit      edit a milestone on a timeline (edit milestone)
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(MilestoneTemplate $milestoneTemplate)
    {
        
    }
}
