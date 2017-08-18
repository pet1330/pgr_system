<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\TimelineTemplate;
use App\Models\MilestoneTemplate;
use App\Http\Controllers\Controller;

class MilestoneTemplateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TimelineTemplate $timelineTemplate, MilestoneTemplate $milestoneTemplate)
    {
        // milestone store     add milestone to timeline (create milestone)
        $mt = MilestoneTemplate::create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimelineTemplate $timelineTemplate, MilestoneTemplate $milestoneTemplate)
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
        // milestone delete    remove milestone from timeline (delete milestone)
        
    }
}
