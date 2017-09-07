<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\AbsenceType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\AbsenceTypeRequest;

class AbsenceTypeController extends Controller
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

        $absencetypes = AbsenceType::withCount([
            'absence',
            'absence AS currentabsence' => function ($query) {
                $query->where('from', '<=', Carbon::now())
                      ->where('to', '>=', Carbon::now());
            }])->orderBy('name');

          return Datatables::eloquent($absencetypes)
              ->editColumn('interuption', '{{$interuption ? "Yes" : "No" }}')
              ->addColumn('editaction', function (AbsenceType $at) {
                return '<form method="GET" action="' . route('admin.settings.absence-type.edit', $at->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (AbsenceType $at) {
                  return '<form method="POST" action="' . route('admin.settings.absence-type.destroy', $at->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedAbsenceType = AbsenceType::onlyTrashed()->get();
        return view('admin.settings.absencetype.index', compact('deletedAbsenceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AbsenceTypeRequest $request)
    {
        $abs = AbsenceType::create($request->all());
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', 'Successfully added "' . $abs->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AbsenceTypeRequest $request, AbsenceType $absence_type)
    {
      $absence_type->update($request->all());
      $absence_type->save();
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', 'Successfully updated "' . $absence_type->name . '"');
    }

    public function edit(AbsenceType $absence_type)
    {
      return view('admin.settings.absencetype.edit', compact('absence_type'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(AbsenceType $absence_type)
    {
        // We are using soft delete so this item will remain in the database
        $absence_type->delete();
        return redirect()
            ->route('admin.settings.absence-type.index')
            ->with('flash', 'Successfully deleted "' . $absence_type->name . '"');
    }

    public function restore($id)
    {
        $abs = AbsenceType::withTrashed()->find($id);
        if($abs->trashed())
        {
            $abs->restore();
            return redirect()
                ->route('admin.settings.absence-type.index')
                ->with('flash', 'Successfully restored "' . $abs->name . '"');
        }
        return redirect()
                ->route('admin.settings.absence-type.index')
                ->with('flash', 'Error: Absence Type is not deleted: "' . $abs->name . '"');
    }
}
