<?php

namespace App\Http\Controllers\Admin;

use App\Models\Programme;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgrammeRequest;
use Yajra\Datatables\Facades\Datatables;

class ProgrammeController extends Controller
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
        $programmes = Programme::withCount('students')->orderBy('name');

          return Datatables::eloquent($programmes)
              ->addColumn('editaction', function (Programme $programme) {
                return '<form method="GET" action="' . route('admin.settings.programmes.edit', $programme->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (Programme $programme) {
                  return '<form method="POST" action="' . route('admin.settings.programmes.destroy', $programme->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedProgrammes = Programme::onlyTrashed()->get();
        return view('admin.settings.programme.index', compact('deletedProgrammes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProgrammeRequest $request)
    {
        $progs = Programme::create($request->all());
        return redirect()
            ->route('admin.settings.programmes.index')
            ->with('flash', 'Successfully added "' . $progs->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgrammeRequest $request, Programme $programme)
    {
        $programme->update($request->all());
        $programme->save();
        return redirect()
            ->route('admin.settings.programmes.index')
            ->with('flash', 'Successfully updated "' . $programme->name . '"');
    }

    public function edit(Programme $programme)
    {
        return view('admin.settings.programme.edit', compact('programme'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgrammeRequest $request, Programme $programme)
    {
        // We are using soft delete so this item will remain in the database
        $programme->delete();
        return redirect()
            ->route('admin.settings.programmes.index')
            ->with('flash', 'Successfully deleted "' . $programme->name . '"');
    }

    public function restore($id)
    {
        $prog = Programme::withTrashed()->find($id);
        if($prog->trashed())
        {
            $prog->restore();
            return redirect()
                ->route('admin.settings.programmes.index')
                ->with('flash', 'Successfully restored "' . $prog->name . '"');
        }
        return redirect()
                ->route('admin.settings.programmes.index')
                ->with('flash', 'Error: Programme is not deleted: "' . $prog->name . '"');
    }
}
