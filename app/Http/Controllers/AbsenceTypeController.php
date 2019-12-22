<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsenceTypeRequest;
use App\Models\AbsenceType;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class AbsenceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorise('manage', AbsenceType::class);

        if ($request->ajax()) {
            $absencetypes = AbsenceType::select('absence_types.*')->withCount([
            'absence',
            'absence AS currentabsence_count' => function ($query) {
                $query->where('from', '<=', Carbon::now())
                      ->where('to', '>=', Carbon::now());
            }, ]);

            return Datatables::eloquent($absencetypes)
              ->editColumn('interuption', '{{$interuption ? "Yes" : "No" }}')
              ->addColumn('editaction', function (AbsenceType $at) {
                  return '<form method="GET" action="'.route('settings.absence-type.edit', $at->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
              })
                ->addColumn('deleteaction', function (AbsenceType $at) {
                    return '<form method="POST" action="'.route('settings.absence-type.destroy', $at->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">'.
                  csrf_field().'<button class="btn btn-danger">
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
        $this->authorise('manage', AbsenceType::class);

        $abs = AbsenceType::create($request->only(['name', 'interuption']));

        return redirect()
            ->route('settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully added "'.$abs->name.'"',
                'type' => 'success',
            ]);
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
        $this->authorise('manage', $absence_type);

        $absence_type->update($request->only(['name', 'interuption']));
        $absence_type->save();

        return redirect()
            ->route('settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully updated "'.$absence_type->name.'"',
                'type' => 'success',
            ]);
    }

    public function edit(AbsenceType $absence_type)
    {
        $this->authorise('manage', $absence_type);

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
        $this->authorise('manage', $absence_type);

        // We are using soft delete so this item will remain in the database
        $absence_type->delete();

        return redirect()
            ->route('settings.absence-type.index')
            ->with('flash', [
                'message' => 'Successfully deleted "'.$absence_type->name.'"',
                'type' => 'success',
            ]);
    }

    public function restore($slug)
    {
        $abs = AbsenceType::withTrashed()->findOrFail(AbsenceType::decodeSlug($slug));

        $this->authorise('manage', $abs);

        if ($abs->trashed()) {
            $abs->restore();

            return redirect()
              ->route('settings.absence-type.index')
              ->with('flash', [
                  'message' => 'Successfully restored "'.$abs->name.'"',
                  'type' => 'success',
              ]);
        }

        return redirect()
            ->route('settings.absence-type.index')
            ->with('flash', [
                'message' => 'Error: Absence Type is not deleted: "'.$abs->name.'"',
                'type' => 'danger',
            ]);
    }
}
