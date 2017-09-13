@extends('layouts.dashboard')
@section('page_title', 'Create New Absence')
@section('page_description', $student->name)
@section('content')
<div id="app">
  <section class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <form action="{{ route('admin.student.absence.store', $student->university_id) }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }} col-md-3">
            <label for="from">From</label>
            <input type="date" class="form-control" name="from" value="{{ old('from') }}">
            @if ($errors->has('from'))
            <span class="help-block">
              <strong>{{ $errors->first('from') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('to') ? ' has-error' : '' }} col-md-3">
            <label for="to">To</label>
            <input type="date" class="form-control" name="to" value="{{ old('to') }}">
            @if ($errors->has('to'))
            <span class="help-block">
              <strong>{{ $errors->first('to') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('absence_type_id') ? ' has-error' : '' }} col-md-4">
            <label for="absence_type_id">Absence Type</label>
            <select class="form-control" name="absence_type_id">
              <option value="">--- Select ---</option>
              @foreach($types as $t)
              <option value="{{ $t->id }}"
                @if( old('absence_type_id') == $t->id )
                selected="selected"
                @endif>
                {{ $t->name }}
              </option>
              @endforeach
            </select>
            @if ($errors->has('absence_type_id'))
            <span class="help-block">
              <strong>{{ $errors->first('absence_type_id') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }} col-md-2">
            <label for="duration">Duration</label>
            <input type="number" step="1" class="form-control" name="duration" value="{{ old('duration') }}">
            @if ($errors->has('duration'))
            <span class="help-block">
              <strong>{{ $errors->first('duration') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Absence</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection