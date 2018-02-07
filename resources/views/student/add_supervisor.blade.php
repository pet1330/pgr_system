@extends('layouts.dashboard')
@section('page_title', 'Assign Supervisor')
@section('page_description', '')
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <label>Add Supervisor</label>
    <form action="{{ route('student.record.supervisor.store',
      [$student->university_id, $record->slug()]) }}" method="POST">
      <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="form-group{{ $errors->has('staff_id') ? ' has-error' : '' }} col-md-4">
        <label for="staff_id">Staff Member</label>
        <select class="form-control" name="staff_id">
          <option value="">--- Select ---</option>
          @foreach($student->records as $t)
          <option value="{{ $t->id }}"
            @if( old('staff_id') == $t->id )
            selected="selected"
            @endif>
            {{ $t->name }}
          </option>
          @endforeach
        </select>
        @if ($errors->has('staff_id'))
        <span class="help-block">
          <strong>{{ $errors->first('staff_id') }}</strong>
        </span>
        @endif
      </div>
      <button type="submit" class="btn btn-primary">Add Supervisor</button>
    </form>
  </div>
</div>
@endsection
