@extends('layouts.dashboard')
@section('page_title', 'Create a Supervisor')
@section('page_description', "")
@section('content')
<div class="row">
  <div class="col-md-3 col-md-offset-4">
    <div class="thumbnail">
      <img src="{{ $staff->avatar(400) }}">
      <div class="caption">
        <h3>{{ $staff->name }}</h3>
        <div class="form-group text-center">
          <form action="{{ route('supervisor.store',
            [$student->university_id, $record->slug(), $staff->university_id]) }}" method="POST">
            <input type="hidden" name="supervisor" value="{{ $staff->university_id }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
              <label for="type">Supervisor Type</label>
              <select class="form-control" name="type">
                <option value="">--- Select ---</option>
                <option value="1">Director of Study</option>
                <option value="2">Second Supervisor</option>
                <option value="3">Third Supervisor</option>
              </select>
              @if ($errors->has('type'))
              <span class="help-block">
                <strong>{{ $errors->first('type') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group">
              <button type="submit" class="col-md-8 col-md-offset-2 btn btn-primary" role="button">
                Add Supervisor
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection