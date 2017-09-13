<?php

namespace App\Http\Controllers\Admin;

use App\Models\School;
use App\Models\College;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolRequest;
use Yajra\Datatables\Facades\Datatables;

class SchoolController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $this->authorise('view', School::class);

        if ($request->ajax())
        {
        $schools = School::with([
            'college' => function ($q) { $q->withTrashed(); }
            ])->withCount('students');

          return Datatables::eloquent($schools)
          ->addColumn('college', function (School $s)
                    { return $s->college->name; })
              ->addColumn('editaction', function (School $school) {
                return '<form method="GET" action="' . route('admin.settings.school.edit', $school->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (School $school) {
                  return '<form method="POST" action="' . route('admin.settings.school.destroy', $school->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
              })
                ->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedSchools = School::onlyTrashed()->get();
        $colleges = College::all();
        return view('admin.settings.school.index', compact('deletedSchools', 'colleges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolRequest $request)
    {

        $this->authorise('create', School::class);

        $school = School::create($request->all());
        return redirect()
            ->route('admin.settings.school.index')
            ->with('flash', 'Successfully added "' . $school->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolRequest $request, School $school)
    {
        
        $this->authorise('update', $school);

        $school->update($request->all());
        $school->save();
        return redirect()
            ->route('admin.settings.school.index')
            ->with('flash', 'Successfully updated "' . $school->name . '"');
    }

    public function edit(School $school)
    {

        $this->authorise('view', $school);

        $colleges = College::all();
        return view('admin.settings.school.edit', compact('school', 'colleges'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolRequest $request, School $school)
    {

        $this->authorise('delete', $school);

        // We are using soft delete so this item will remain in the database
        $school->delete();
        return redirect()
            ->route('admin.settings.school.index')
            ->with('flash', 'Successfully deleted "' . $school->name . '"');
    }

    public function restore($id)
    {
        
        $this->authorise('delete', $school);

        $school = School::withTrashed()->find($id);
        if($school->trashed())
        {
            $school->restore();
            return redirect()
                ->route('admin.settings.school.index')
                ->with('flash', 'Successfully restored "' . $school->name . '"');
        }
        return redirect()
                ->route('admin.settings.school.index')
                ->with('flash', 'Error: School is not deleted: "' . $school->name . '"');
    }
}
