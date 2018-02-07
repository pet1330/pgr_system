<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollegeRequest;
use Yajra\Datatables\Facades\Datatables;

class CollegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorise('manage', College::class);

        if ($request->ajax())
        {
        $colleges = College::select('colleges.*')->withCount('schools');

          return Datatables::eloquent($colleges)
              ->addColumn('editaction', function (College $college) {
                return '<form method="GET" action="' . route('admin.settings.college.edit', $college->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (College $college) {
                  return '<form method="POST" action="' . route('admin.settings.college.destroy', $college->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedColleges = College::onlyTrashed()->get();
        return view('admin.settings.college.index', compact('deletedColleges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollegeRequest $request)
    {

        $this->authorise('manage', College::class);

        $college = College::create($request->only( 'name' ));
        return redirect()
            ->route('admin.settings.college.index')
            ->with('flash', [
              'message' => 'Successfully added "' . $college->name . '"',
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
    public function update(CollegeRequest $request, College $college)
    {

        $this->authorise('manage', $college);

        $college->update( $request->only( 'name' ) );
        $college->save();
        return redirect()
            ->route('admin.settings.college.index')
            ->with('flash', [
              'message' => 'Successfully updated "' . $college->name . '"',
              'type' => 'success'
            ]);
    }

    public function edit(College $college)
    {

        $this->authorise('manage', $college);

        return view('admin.settings.college.edit', compact('college'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollegeRequest $request, College $college)
    {

        $this->authorise('manage', $college);

        // We are using soft delete so this item will remain in the database
        $college->delete();
        return redirect()
            ->route('admin.settings.college.index')
            ->with('flash', [
              'message' => 'Successfully deleted "' . $college->name . '"',
              'type' => 'success'
            ]);
    }

    public function restore($id)
    {
        $college = College::withTrashed()->find($id);

        $this->authorise('manage', $college);

        if($college->trashed())
        {
            $college->restore();
            return redirect()
                ->route('admin.settings.college.index')
                ->with('flash', [
                  'message' => 'Successfully restored "' . $college->name . '"',
                  'type' => 'success'
                ]);
        }
        return redirect()
            ->route('admin.settings.college.index')
            ->with('flash', [
              'message' => 'Error: College is not deleted: "' . $college->name . '"',
              'type' => 'danger'
            ]);
    }
}
