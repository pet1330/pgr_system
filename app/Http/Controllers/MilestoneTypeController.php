<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\MilestoneType;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\MilestoneTypeRequest;

class MilestoneTypeController extends Controller
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
            $miletypes = MilestoneType::withCount(['milestones', 'milestone_templates'])->orderBy('name');

            return Datatables::eloquent($miletypes)
                ->editColumn('student_makable', '{{ $student_makable ? "Yes" : "No" }}')
                ->addColumn('editaction', function (MilestoneType $mt) {
                    return '<form method="GET" action="' . route('admin.settings.milestone-type.edit', $mt->id) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (MilestoneType $mt) {
                      return '<form method="POST" action="' . route('admin.settings.milestone-type.destroy', $mt->id) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <input type="hidden" name="_method" value="DELETE">' . 
                      csrf_field() . '<button class="btn btn-danger">
                      <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedMilestoneType = MilestoneType::onlyTrashed()->get();
        return view('admin.settings.milestonetype.index', compact('deletedMilestoneType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MilestoneTypeRequest $request)
    {
        $mt = MilestoneType::create( $request->all() );
        return redirect()
            ->route('admin.settings.milestone-type.index')
            ->with('flash', 'Successfully added "' . $mt->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MilestoneTypeRequest $request, MilestoneType $milestone_type)
    {
        $milestone_type->update($request->all());
        $milestone_type->save();
        return redirect()
            ->route('admin.settings.milestone-type.index')
            ->with('flash', 'Successfully updated "' . $milestone_type->name . '"');
    }

    public function edit(MilestoneType $milestone_type)
    {
      return view('admin.settings.milestonetype.edit', compact('milestone_type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MilestoneType $milestone_type)
    {
        // We are using soft delete so this item will remain in the database
        $milestone_type->delete();
        return redirect()
            ->route('admin.settings.milestone-type.index')
            ->with('flash', 'Successfully deleted "' . $milestone_type->name . '"');
    }

    public function restore($id)
    {
        $mt = MilestoneType::withTrashed()->find($id);
        if($mt->trashed())
        {
            $mt->restore();
            return redirect()
                ->route('admin.settings.milestone-type.index')
                ->with('flash', 'Successfully restored "' . $mt->name . '"');
        }
        return redirect()
                ->route('admin.settings.milestone-type.index')
                ->with('flash', 'Error: Milestone Type is not deleted: "' . $mt->name . '"');
    }
}