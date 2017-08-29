@extends('layouts.dashboard')
@section('page_title', 'Absence Types')
@section('page_description', 'Current list of absence types')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-absence-type-table')
    <td>Absence Type</td>
    <td>Interuption</td>
    <td>Current</td>
    <td>Total</td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new absence type</label>
        <form action="{{ route('admin.settings.absence-type.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('interuption') ? ' has-error' : '' }} col-md-4">
            <select class="form-control" name="interuption">
              <option value="">--- Select ---</option>
              <option value="1" @if(old('interuption') == '1') selected="selected" @endif>
                Interuption
              </option>
              <option value="0" @if(old('interuption') == '0')) selected="selected" @endif>
                Not Interuption
              </option>
            </select>
            @if ($errors->has('interuption'))
            <span class="help-block">
              <strong>{{ $errors->first('interuption') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Add Absence Type</button>
        </form>
      </div>
    </div>
    @if($deletedAbsenceType->isNotEmpty())
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Absence Types
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
            @foreach($deletedAbsenceType as $dat)
            <div class="col-md-12">
              <a href="{{ route('admin.settings.absence-type.restore', $dat->id) }}">
                <span class="btn btn-success">Restore</span>
              </a>
              {{ $dat->name }}
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
</li>
@endsection