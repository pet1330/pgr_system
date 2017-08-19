@extends('layouts.dashboard')
@section('page_title', 'Update Student Status')
@section('page_description', $student_status->status)
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <label>Update Student Status</label>
    <form action="{{ route('admin.settings.student-status.update', $student_status->id) }}" method="POST">
    <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} col-md-12">
        <input type="text" class="form-control" placeholder="Status" name="status" value="{{ old('status') ?? $student_status->status }}">
        @if ($errors->has('status'))
        <span class="help-block">
          <strong>{{ $errors->first('status') }}</strong>
        </span>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Update Status</button>
    </form>
  </div>
</div>
@endsection