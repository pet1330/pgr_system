@if ($errors->has('university_id'))
<script>
window.location = "{{ route('admin.student.find') }}";
</script>
@endif
@extends('layouts.dashboard')
@section('page_title', 'Create New Student')
@section('page_description', '')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new Student</label>
        <form action="{{ route('admin.student.store') }}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="university_id" value="{{ $university_id or old('university_id') }}">
          <div class="row">
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }} col-md-4">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" placeholder="Name" name="first_name" value="{{ old('first_name') }}">
              @if ($errors->has('first_name'))
              <span class="help-block">
                <strong>{{ $errors->first('first_name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-4">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" placeholder="Name" name="last_name" value="{{ old('last_name') }}">
              @if ($errors->has('last_name'))
              <span class="help-block">
                <strong>{{ $errors->first('last_name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }} col-md-4">
              <label for="university_email">Email Address</label>
              <input type="text" class="form-control" placeholder="Name" name="university_email" value="{{ $university_id ? $university_id."@students.lincoln.ac.uk" : old('university_email') }}">
              @if ($errors->has('university_email'))
              <span class="help-block">
                <strong>{{ $errors->first('university_email') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Add New Student</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection