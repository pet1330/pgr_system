<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundingTypeRequest;
use App\Models\FundingType;
use DataTables;
use Illuminate\Http\Request;

class FundingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorise('manage', FundingType::class);

        if ($request->ajax()) {
            $fundingTypes = FundingType::select('funding_types.*')->withCount('students');

            return Datatables::eloquent($fundingTypes)
              ->addColumn('editaction', function (FundingType $ft) {
                  return '<form method="GET" action="'.route('settings.funding-type.edit', $ft->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <button class="btn btn-warning">
                  <i class="fa fa-pencil"></i></button> </form>';
              })
                ->addColumn('deleteaction', function (FundingType $ft) {
                    return '<form method="POST" action="'.route('settings.funding-type.destroy', $ft->slug()).'"
                  accept-charset="UTF-8" class="delete-form">
                  <input type="hidden" name="_method" value="DELETE">'.
                  csrf_field().'<button class="btn btn-danger">
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
        $this->authorise('manage', FundingType::class);

        $fun = FundingType::create($request->only('name'));

        return redirect()
            ->route('settings.funding-type.index')
              ->with('flash', [
                  'message' => 'Successfully added "'.$fun->name.'"',
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
    public function update(FundingTypeRequest $request, FundingType $funding_type)
    {
        $this->authorise('manage', $funding_type);

        $funding_type->update($request->only('name'));
        $funding_type->save();

        return redirect()
            ->route('settings.funding-type.index')
            ->with('flash', [
                'message' => 'Successfully updated "'.$funding_type->name.'"',
                'type' => 'success',
            ]);
    }

    public function edit(FundingType $funding_type)
    {
        $this->authorise('manage', $funding_type);

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
        $this->authorise('manage', $funding_type);

        // We are using soft delete so this item will remain in the database
        $funding_type->delete();

        return redirect()
            ->route('settings.funding-type.index')
            ->with('flash', [
                'message' => 'Successfully deleted "'.$funding_type->name.'"',
                'type' => 'success',
            ]);
    }

    public function restore($slug)
    {
        $funding_type = FundingType::withTrashed()->findOrFail(FundingType::decodeSlug($slug));

        $this->authorise('manage', $funding_type);

        if ($funding_type->trashed()) {
            $funding_type->restore();

            return redirect()
                ->route('settings.funding-type.index')
                ->with('flash', [
                    'message' => 'Successfully restored "'.$funding_type->name.'"',
                    'type' => 'success',
                ]);
        }

        return redirect()
            ->route('settings.funding-type.index')
            ->with('flash', [
                'message' => 'Error: Absence Type is not deleted: "'.$funding_type->name.'"',
                'type' => 'danger',
            ]);
    }
}
