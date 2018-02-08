@extends('layouts.dashboard')
@section('page_title', 'Create a Student Record')
@section('page_description', "")
@section('content')
<div class="col-md-6 col-md-offset-3 text-center">
  <div class="box box box-primary">
    <div class="box-body">
      <label>Please enter the students univeristy ID</label>
      <form action="{{ route('student.find') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('university_id') || $errors->has('nomatch') ? ' has-error' : '' }}">
          <input type="text" class="form-control" placeholder="University ID" name="university_id" value="{{ old('university_id') }}">
          @if ($errors->has('university_id'))
          <span class="help-block">
            <strong>{{ $errors->first('university_id') }}</strong>
          </span>
          @endif
          @if ($errors->has('nomatch'))
          <span class="help-block">
            <strong>{{ $errors->first('nomatch') }}</strong>
          </span>
          @endif
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Find</button>
      </form>
    </div>
  </div>
</div>
@endsection