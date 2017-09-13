<?php

namespace App\Http\Controllers\Admin;

use App\Models\ModeOfStudy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModeOfStudyRequest;
use Yajra\Datatables\Facades\Datatables;

class ModeOfStudyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorise('view', ModeOfStudy::class);

        if ($request->ajax())
        {
        $modeOfStudy = ModeOfStudy::withCount('students')->orderBy('name');

          return Datatables::eloquent($modeOfStudy)
              ->addColumn('editaction', function (ModeOfStudy $modeOfStudy) {
                return '<form method="GET" action="' . route('admin.settings.mode-of-study.edit', $modeOfStudy->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (ModeOfStudy $modeOfStudy) {
                  return '<form method="POST" action="' . route('admin.settings.mode-of-study.destroy', $modeOfStudy->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
                })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedModesofStudy = ModeOfStudy::onlyTrashed()->get();
        return view('admin.settings.modeofstudy.index', compact('deletedModesofStudy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModeOfStudyRequest $request)
    {

        $this->authorise('create', ModeOfStudy::class);

        $modes = ModeOfStudy::create($request->all());
        return redirect()
            ->route('admin.settings.mode-of-study.index')
            ->with('flash', 'Successfully added "' . $modes->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModeOfStudyRequest $request, ModeOfStudy $modeOfStudy)
    {

        $this->authorise('update', $modeOfStudy);

        $modeOfStudy->update($request->all());
        $modeOfStudy->save();
        return redirect()
            ->route('admin.settings.mode-of-study.index')
            ->with('flash', 'Successfully updated "' . $modeOfStudy->name . '"');

        return "update";
    }

    public function edit(ModeOfStudy $modeOfStudy)
    {

        $this->authorise('update', $modeOfStudy);

        return view('admin.settings.modeofstudy.edit', compact('modeOfStudy'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModeOfStudyRequest $request, ModeOfStudy $modeOfStudy)
    {

        $this->authorise('delete', $modeOfStudy);

        // We are using soft delete so this item will remain in the database
        $modes = ModeOfStudy::find($id);
        $modes->delete();
        return redirect()
            ->route('admin.settings.mode-of-study.index')
            ->with('flash', 'Successfully deleted "' . $modes->name . '"');
    }

    public function restore($id)
    {
        $mod = ModeOfStudy::withTrashed()->find($id);

        $this->authorise('delete', $mod);

        if($mod->trashed())
        {
            $mod->restore();
            return redirect()
                ->route('admin.settings.mode-of-study.index')
                ->with('flash', 'Successfully restored "' . $mod->name . '"');
        }
        return redirect()
                ->route('admin.settings.mode-of-study.index')
                ->with('flash', 'Error: Mode of Study is not deleted: "' . $mod->name . '"');
    }
}
