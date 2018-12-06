<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Programme;
use Illuminate\Http\Request;
use App\Http\Requests\ProgrammeRequest;

class ProgrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorise('manage', Programme::class);

        if ($request->ajax()) {
            $programmes = Programme::select('programmes.*')->withCount('students');

            return Datatables::eloquent($programmes)
              ->addColumn('editaction', function (Programme $programme) {
                  return '<form method="GET" action="'.route('settings.programme.edit', $programme->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
              })
                ->addColumn('deleteaction', function (Programme $programme) {
                    return '<form method="POST" action="'.route('settings.programme.destroy', $programme->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">'.
                  csrf_field().'<button class="btn btn-danger">
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
        $this->authorise('manage', Programme::class);

        $progs = Programme::create($request->only(['name', 'duration']));

        return redirect()
            ->route('settings.programme.index')
            ->with('flash', [
                'message' => 'Successfully added "'.$progs->name.'"',
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
    public function update(ProgrammeRequest $request, Programme $programme)
    {
        $this->authorise('manage', $programme);

        $programme->update($request->only('name', 'duration'));
        $programme->save();

        return redirect()
            ->route('settings.programme.index')
            ->with('flash', [
                'message' => 'Successfully updated "'.$programme->name.'"',
                'type' => 'success',
            ]);
    }

    public function edit(Programme $programme)
    {
        $this->authorise('manage', $programme);

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
        $this->authorise('manage', $programme);

        // We are using soft delete so this item will remain in the database
        $programme->delete();

        return redirect()
            ->route('settings.programme.index')
            ->with('flash', [
                'message' => 'Successfully deleted "'.$programme->name.'"',
                'type' => 'success',
            ]);
    }

    public function restore($slug)
    {
        $prog = Programme::withTrashed()->findOrFail(Programme::decodeSlug($slug));

        $this->authorise('manage', $prog);

        if ($prog->trashed()) {
            $prog->restore();

            return redirect()
                ->route('settings.programme.index')
            ->with('flash', [
                'message' => 'Successfully restored "'.$prog->name.'"',
                'type' => 'success',
            ]);
        }

        return redirect()
            ->route('settings.programme.index')
            ->with('flash', [
                'message' => 'Error: Programme is not deleted: "'.$prog->name.'"',
                'type' => 'danger',
            ]);
    }
}
