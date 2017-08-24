@extends('layouts.dashboard')
@section('page_title', 'Update Absence Type ')
@section('page_description', $absence_type->name)
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <label>Update absence type</label>
    <form action="{{ route('admin.settings.absence-type.update', $absence_type->id) }}" method="POST">
      <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $absence_type->name }}">
        @if ($errors->has('name'))
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('interuption') ? ' has-error' : '' }} col-md-4">
        <select class="form-control" name="interuption">
          <option>--- Select ---</option>
          <option value="1"
            @if(old('interuption') == '1' or $absence_type->interuption == '1')
            selected="selected"
            @endif>
            Interuption
          </option>
          <option value="0"
            @if(old('interuption') == '0' or $absence_type->interuption == '0')
            selected="selected"
            @endif>Not Interuption
          </option>
        </select>
        @if ($errors->has('interuption'))
        <span class="help-block">
          <strong>{{ $errors->first('interuption') }}</strong>
        </span>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Update Absence Type</button>
    </form>
  </div>
</div>
@endsection