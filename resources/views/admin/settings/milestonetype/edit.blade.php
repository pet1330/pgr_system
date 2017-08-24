@extends('layouts.dashboard')
@section('page_title', 'Update Milestone Type ')
@section('page_description', $milestone_type->name)
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <label>Update milestone type</label>
    <form action="{{ route('admin.settings.milestone-type.update', $milestone_type->id) }}" method="POST">
      <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $milestone_type->name }}">
        @if ($errors->has('name'))
        <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
        </span>
        @endif
      </div>
        <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }} col-md-4">
          <input type="number" step="1" class="form-control" placeholder="Duration in Days" name="duration" value="{{ old('duration') ?? $milestone_type->duration }}">
          @if ($errors->has('duration'))
            <span class="help-block">
              <strong>{{ $errors->first('duration') }}</strong>
            </span>
          @endif
        </div>
      <button type="submit" class="btn btn-primary">Update Milestone Type</button>
    </form>
  </div>
</div>
@endsection