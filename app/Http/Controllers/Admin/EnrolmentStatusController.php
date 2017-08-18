<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\EnrolmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnrolmentStatusRequest;
use Yajra\Datatables\Facades\Datatables;

class EnrolmentStatusController extends Controller
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
            $enrolment_status = EnrolmentStatus::withCount('students')->orderBy('status');

            return Datatables::eloquent($enrolment_status)
              ->addColumn('editaction', function (EnrolmentStatus $enrolment_status) {
                return '<form method="GET" action="' . route('admin.settings.enrolment-status.edit', $enrolment_status->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (EnrolmentStatus $enrolment_status) {
                  return '<form method="POST" action="' . route('admin.settings.enrolment-status.destroy', $enrolment_status->id) . '"
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
        $enrolments = EnrolmentStatus::create($request->all());
        return redirect()
            ->route('admin.settings.enrolment-status.index')
            ->with('flash', 'Successfully added "' . $enrolments->status . '"');
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
        $enrolment_status->update($request->all());
        $enrolment_status->save();
        return redirect()
            ->route('admin.settings.enrolment-status.index')
            ->with('flash', 'Successfully updated "' . $enrolment_status->status . '"');
    }

    public function edit(EnrolmentStatus $enrolment_status)
    {
        return view('admin.settings.enrolmentstatus.edit', compact('enrolment_status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnrolmentStatusRequest $request, $id)
    {
        // We are using soft delete so this item will remain in the database
        $enrolments = EnrolmentStatus::find($id);
        $enrolments->delete();
        return redirect()
            ->route('admin.settings.enrolment-status.index')
            ->with('flash', 'Successfully deleted "' . $enrolments->status . '"');
    }

    public function restore($id)
    {
        $enrolment_status = EnrolmentStatus::withTrashed()->find($id);
        if($enrolment_status->trashed())
        {
            $enrolment_status->restore();
            return redirect()
                ->route('admin.settings.enrolment-status.index')
                ->with('flash', 'Successfully restored "' . $enrolment_status->status . '"');
        }
        return redirect()
                ->route('admin.settings.enrolment-status.index')
                ->with('flash', 'Error: Status is not deleted: "' . $enrolment_status->status . '"');
    }
}
