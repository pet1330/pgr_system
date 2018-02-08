<?php

namespace App\Http\Controllers;

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

      $this->authorise('manage', MilestoneType::class);

        if ($request->ajax())
        {
            $miletypes = MilestoneType::select('milestone_types.*')->withCount(['milestones', 'milestone_templates']);

            return Datatables::eloquent($miletypes)
                ->editColumn('student_makable', '{{ $student_makable ? "Yes" : "No" }}')
                ->addColumn('editaction', function (MilestoneType $mt) {
                    return '<form method="GET" action="' . route('settings.milestone-type.edit', $mt->id) . '"
                      accept-charset="UTF-8" class="delete-form">
                      <button class="btn btn-warning">
                      <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (MilestoneType $mt) {
                      return '<form method="POST" action="' . route('settings.milestone-type.destroy', $mt->id) . '"
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

      $this->authorise('manage', MilestoneType::class);

        $mt = MilestoneType::create( $request->only([ 'name', 'duration', 'student_makable' ] ) );
        return redirect()
            ->route('settings.milestone-type.index')
            ->with('flash', [
                'message' => 'Successfully added "' . $mt->name . '"',
                'type' => 'success'
            ]);
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

        $this->authorise('manage', $milestone_type);

        $milestone_type->update( $request->only( 'name', 'duration', 'student_makable' ) );
        $milestone_type->save();
        return redirect()
            ->route('settings.milestone-type.index')
            ->with('flash', [
                'message' => 'Successfully updated "' . $milestone_type->name . '"',
                'type' => 'success'
            ]);
    }

    public function edit(MilestoneType $milestone_type)
    {

        $this->authorise('manage', $milestone_type);

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

        $this->authorise('manage', $milestone_type);

        // We are using soft delete so this item will remain in the database
        $milestone_type->delete();
        return redirect()
            ->route('settings.milestone-type.index')
            ->with('flash', [
                'message' => 'Successfully deleted "' . $milestone_type->name . '"',
                'type' => 'success'
            ]);
    }

    public function restore($id)
    {
        $mt = MilestoneType::withTrashed()->find($id);

        $this->authorise('manage', $mt);

        if($mt->trashed())
        {
            $mt->restore();
            return redirect()
                ->route('settings.milestone-type.index')
            ->with('flash', [
                'message' => 'Successfully restored "' . $mt->name . '"',
                'type' => 'success'
            ]);
        }
        return redirect()
            ->route('settings.milestone-type.index')
            ->with('flash', [
                'message' => 'Error: Milestone Type is not deleted: "' . $mt->name . '"',
                'type' => 'danger'
            ]);
    }
}
