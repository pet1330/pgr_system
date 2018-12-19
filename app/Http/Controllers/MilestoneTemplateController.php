<?php

namespace App\Http\Controllers;

use App\Models\MilestoneType;
use App\Models\TimelineTemplate;
use App\Models\MilestoneTemplate;
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
        $this->authorise('manage', $timeline);

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
        $this->authorise('manage', $timeline);

        $milestone = $timeline->milestone_templates()->save(
            MilestoneTemplate::make([
                'due' => $request->due,
                'milestone_type_id' => $request->milestone_type,
            ])
        );

        return redirect()
            ->route('settings.timeline.show', $timeline->slug())
            ->with('flash', [
                'message' => 'Successfully added "'.$milestone->type->name.'"',
                'type' => 'success',
            ]);
    }

    public function edit(TimelineTemplate $timeline, MilestoneTemplate $milestone)
    {
        $this->authorise('manage', $timeline);

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
        $this->authorise('manage', $timeline);

        $milestone->update($request->only(['due', 'milestone_type']));

        return redirect()
            ->route('settings.timeline.show', $timeline->slug())
            ->with('flash', [
                'message' => 'Successfully updated "'.$milestone->type->name.'"',
                'type' => 'success',
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
        $this->authorise('manage', $timeline);

        $milestone->delete();

        return redirect()
            ->route('settings.timeline.show', $timeline->slug())
            ->with('flash', [
                'message' => 'Successfully deleted "'.$milestone->type->name.'"',
                'type' => 'success',
            ]);
    }

    public function restore(TimelineTemplate $timeline, $slug)
    {
        $mt = MilestoneTemplate::withTrashed()->findOrFail(MilestoneTemplate::decodeSlug($slug));

        $this->authorise('manage', $mt->timeline_template);

        if ($mt->trashed()) {
            $mt->restore();

            return redirect()
                ->route('settings.timeline.show', $mt->timeline_template->slug())
                ->with('flash', [
                'message' => 'Successfully restored "'.$mt->type->name.'"',
                'type' => 'success',
            ]);
        }

        return redirect()
                ->route('settings.timeline.show', $mt->timeline_template->slug())
                ->with('flash', [
                'message' => 'Error: Milestone Template has not deleted: "'.$mt->type->name.'"',
                'type' => 'danger',
            ]);
    }
}
