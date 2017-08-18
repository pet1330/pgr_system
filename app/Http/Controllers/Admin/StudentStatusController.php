<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\StudentStatus;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\StudentStatusRequest;

class StudentStatusController extends Controller
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
        $student_status = StudentStatus::withCount('students')->orderBy('status');

          return Datatables::eloquent($student_status)
              ->addColumn('editaction', function (StudentStatus $student_status) {
                return '<form method="GET" action="' . route('admin.settings.student-status.edit', $student_status->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (StudentStatus $student_status) {
                  return '<form method="POST" action="' . route('admin.settings.student-status.destroy', $student_status->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedStatuses = StudentStatus::onlyTrashed()->get();
        return view('admin.settings.studentstatus.index', compact('deletedStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentStatusRequest $request)
    {
        $stu = StudentStatus::create($request->all());
        return redirect()
            ->route('admin.settings.student-status.index')
            ->with('flash', 'Successfully added "' . $stu->status . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentStatusRequest $request, StudentStatus $student_status)
    {
        $student_status->update($request->all());
        $student_status->save();
        return redirect()
            ->route('admin.settings.student-status.index')
            ->with('flash', 'Successfully updated "' . $student_status->status . '"');
    }

    public function edit(StudentStatus $student_status)
    {
        return view('admin.settings.studentstatus.edit', compact('student_status'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentStatusRequest $request, StudentStatus $student_status)
    {
        // We are using soft delete so this item will remain in the database
        $student_status->delete();
        return redirect()
            ->route('admin.settings.student-status.index')
            ->with('flash', 'Successfully deleted "' . $student_status->status . '"');
    }

    public function restore($id)
    {
        $student_status = StudentStatus::withTrashed()->find($id);
        if($student_status->trashed())
        {
            $student_status->restore();
            return redirect()
                ->route('admin.settings.student-status.index')
                ->with('flash', 'Successfully restored "' . $student_status->status . '"');
        }
        return redirect()
                ->route('admin.settings.student-status.index')
                ->with('flash', 'Error: Status is not deleted: "' . $student_status->status . '"');
    }
}
