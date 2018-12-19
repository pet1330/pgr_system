@extends('layouts.dashboard')
@section('page_title', 'Update Milestone Type ')
@section('page_description', $milestone_type->name)
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <label>Update milestone type</label>
    <form action="{{ route('settings.milestone-type.update', $milestone_type->slug()) }}" method="POST">
      <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
        <label for="milestone_type">Name</label>
        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $milestone_type->name }}">
        @if ($errors->has('name'))
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }} col-md-3">
        <label for="milestone_type">Duration in Days</label>
        <input type="number" step="1" class="form-control" placeholder="Duration in Days" name="duration" value="{{ old('duration') ?? $milestone_type->duration }}">
        @if ($errors->has('duration'))
        <span class="help-block">
          <strong>{{ $errors->first('duration') }}</strong>
        </span>
        @endif
      </div>
      <div class="form-group{{ $errors->has('student_makable') ? ' has-error' : '' }} col-md-3">
      <label for="milestone_type">Create Permissions</label>
        <select class="form-control" name="student_makable">
          <option value="">--- Select ---</option>
          <option value="1"
            @if(old('student_makable') == '1' or $milestone_type->student_makable == '1')
            selected="selected"
            @endif>
            Students can create
          </option>
          <option value="0"
            @if(old('student_makable') == '0' or $milestone_type->student_makable == '0')
            selected="selected"
            @endif>
            Students can not create
          </option>
        </select>
        @if ($errors->has('student_makable'))
        <span class="help-block">
          <strong>{{ $errors->first('student_makable') }}</strong>
        </span>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Update Milestone Type</button>
    </form>
  </div>
</div>
@endsection