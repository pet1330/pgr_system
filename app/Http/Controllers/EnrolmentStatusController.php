<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EnrolmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrolmentStatusRequest;

class EnrolmentStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorise('manage', EnrolmentStatus::class);

        if ($request->ajax())
        {
            $enrolment_status = EnrolmentStatus::select('enrolment_statuses.*')->withCount('students');

            return Datatables::eloquent($enrolment_status)
              ->addColumn('editaction', function (EnrolmentStatus $enrolment_status) {
                return '<form method="GET" action="' . route('settings.enrolment-status.edit', $enrolment_status->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (EnrolmentStatus $enrolment_status) {
                  return '<form method="POST" action="' . route('settings.enrolment-status.destroy', $enrolment_status->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedStatuses = EnrolmentStatus::onlyTrashed()->get();
        return view('admin.settings.enrolmentstatus.index', compact('deletedStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrolmentStatusRequest $request)
    {

        $this->authorise('manage', EnrolmentStatus::class);

        $enrolments = EnrolmentStatus::create($request->only( 'status' ));
        return redirect()
            ->route('settings.enrolment-status.index')
            ->with('flash', [
                'message' => 'Successfully added "' . $enrolments->status . '"',
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
    public function update(EnrolmentStatusRequest $request, EnrolmentStatus $enrolment_status)
    {

        $this->authorise('manage', $enrolment_status);

        $enrolment_status->update($request->only( 'status' ));
        $enrolment_status->save();
        return redirect()
            ->route('settings.enrolment-status.index')
            ->with('flash', [
                'message' => 'Successfully updated "' . $enrolment_status->status . '"',
                'type' => 'success'
            ]);
    }

    public function edit(EnrolmentStatus $enrolment_status)
    {

        $this->authorise('manage', $enrolment_status);

        return view('admin.settings.enrolmentstatus.edit', compact('enrolment_status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnrolmentStatusRequest $request, EnrolmentStatus $enrolment_status)
    {

        $this->authorise('manage', $enrolment_status);

        // We are using soft delete so this item will remain in the database
        $enrolment_status->delete();
        return redirect()
            ->route('settings.enrolment-status.index')
            ->with('flash', [
                'message' => 'Successfully deleted "' . $enrolment_status->status . '"',
                'type' => 'success'
            ]);
    }

    public function restore($id)
    {

        $enrolment_status = EnrolmentStatus::withTrashed()->find($id);
        
        $this->authorise('manage', $enrolment_status);

        if($enrolment_status->trashed())
        {
            $enrolment_status->restore();
            return redirect()
                ->route('settings.enrolment-status.index')
                ->with('flash', [
                    'message' => 'Successfully restored "' . $enrolment_status->status . '"',
                    'type' => 'success'
                ]);
        }
        return redirect()
            ->route('settings.enrolment-status.index')
            ->with('flash', [
                'message' => 'Error: Status is not deleted: "' . $enrolment_status->status . '"',
                'type' => 'success'
            ]);
    }
}
