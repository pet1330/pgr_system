@extends('layouts.dashboard')
@section('page_title', 'Funding Types')
@section('page_description', 'Current list of funding types')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-funding-type-table')
    <th>Funding Type</th>
    <th>Student Count</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new funding type</label>
        <form action="{{ route('admin.settings.funding-type.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Add Funding Type</button>
        </form>
      </div>
    </div>
    @if($deletedFundingType->isNotEmpty())
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Funding Types
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deletedFundingType as $dat)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.funding-type.restore', $dat->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $dat->name }}
              </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</li>
@endsection
