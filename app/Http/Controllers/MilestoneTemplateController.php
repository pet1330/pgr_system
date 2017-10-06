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

        $this->authorise('create', $timeline);

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

        $this->authorise('create', $timeline);

        $milestone = $timeline->milestone_templates()->save(
            MilestoneTemplate::make([
                'due' => $request->due,
                'milestone_type_id' => $request->milestone_type
            ])
        );
        return redirect()
            ->route('admin.settings.timeline.show', $timeline->id)
            ->with('flash', [
                'message' => 'Successfully added "' . $milestone->type->name . '"',
                'type' => 'success'
            ]);
    }

    public function edit(TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        $this->authorise('update', $timeline);

        $types = MilestoneType::all();

        return view('admin.settings.milestonetemplate.edit', compact('timeline', 'milestone', 'types'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(MilestoneTemplateRequest $request,
        TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        $this->authorise('update', $timeline);
        
        $milestone->update( $request->only( [ 'due', 'milestone_type' ] ) );

        return redirect()
            ->route('admin.settings.timeline.show', $timeline->id)
            ->with('flash', [
                'message' => 'Successfully updated "' . $milestone->type->name . '"',
                'type' => 'success'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimelineTemplate $timelineTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        $this->authorise('delete', $timeline);

        $milestone->delete();

        return redirect()
            ->route('admin.settings.timeline.show', $timeline->id)
            ->with('flash', [
                'message' => 'Successfully deleted "' . $milestone->type->name . '"',
                'type' => 'success'
            ]);
    }


    public function restore($id)
    {
        $mt = MilestoneTemplate::withTrashed()->find($id);

        $this->authorise('delete', $mt->timeline_template);

        if($mt->trashed())
        {
            $mt->restore();
            return redirect()
                ->route('admin.settings.timeline.show', $mt->timeline_template->id)
                ->with('flash', [
                'message' => 'Successfully restored "' . $mt->type->name . '"',
                'type' => 'success'
            ]);
        }
        return redirect()
                ->route('admin.settings.timeline.show', $mt->timeline_template->id)
                ->with('flash', [
                'message' => 'Error: Milestone Template has not deleted: "' . $mt->type->name . '"',
                'type' => 'danger'
            ]);
    }
}
