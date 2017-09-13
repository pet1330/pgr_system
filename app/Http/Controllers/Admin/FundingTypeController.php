<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\FundingType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests\FundingTypeRequest;

class FundingTypeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorise('view', FundingType::class);

        if ($request->ajax())
        {

        $fundingTypes = FundingType::withCount('students')->orderBy('name');

          return Datatables::eloquent($fundingTypes)
              ->addColumn('editaction', function (FundingType $ft) {
                return '<form method="GET" action="' . route('admin.settings.funding-type.edit', $ft->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
                })
                ->addColumn('deleteaction', function (FundingType $ft) {
                  return '<form method="POST" action="' . route('admin.settings.funding-type.destroy', $ft->id) . '"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">' . 
                  csrf_field() . '<button class="btn btn-danger">
                  <i class="fa fa-trash"></i></button> </form>';
                })->rawColumns(['editaction', 'deleteaction'])
              ->make(true);
        }

        $deletedFundingType = FundingType::onlyTrashed()->get();
        return view('admin.settings.fundingtype.index', compact('deletedFundingType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FundingTypeRequest $request)
    {

        $this->authorise('create', FundingType::class);

        $fun = FundingType::create($request->all());
        return redirect()
            ->route('admin.settings.funding-type.index')
            ->with('flash', 'Successfully added "' . $fun->name . '"');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FundingTypeRequest $request, FundingType $funding_type)
    {

        $this->authorise('update', $funding_type);

      $funding_type->update($request->all());
      $funding_type->save();
        return redirect()
            ->route('admin.settings.funding-type.index')
            ->with('flash', 'Successfully updated "' . $funding_type->name . '"');
    }

    public function edit(FundingType $funding_type)
    {

        $this->authorise('update', $funding_type);

        return view('admin.settings.fundingtype.edit', compact('funding_type'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundingTypeRequest $request, FundingType $funding_type)
    {

        $this->authorise('delete', $funding_type);

        // We are using soft delete so this item will remain in the database
        $funding_type->delete();
        return redirect()
            ->route('admin.settings.funding-type.index')
            ->with('flash', 'Successfully deleted "' . $funding_type->name . '"');
    }

    public function restore($id)
    {
        $funding_type = FundingType::withTrashed()->find($id);

        $this->authorise('delete', $funding_type);

        if($funding_type->trashed())
        {
            $funding_type->restore();
            return redirect()
                ->route('admin.settings.funding-type.index')
                ->with('flash', 'Successfully restored "' . $funding_type->name . '"');
        }
        return redirect()
                ->route('admin.settings.funding-type.index')
                ->with('flash', 'Error: Absence Type is not deleted: "' . $funding_type->name . '"');
    }
}
