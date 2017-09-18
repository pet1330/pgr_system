@extends('layouts.dashboard')
@section('page_title', 'Copy Timelime Template')
@section('page_description', 'to '.$student->name.'\'s timeline')
@section('content')
<div id="app">
  <div class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <form action="#" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="university_id" value="{{ $student ? $student->university_id : old('university_id') }}">
          <div class="form-group{{ $errors->has('timeline_id') ? ' has-error' : '' }} col-md-12">
            <label for="timeline_id">Timeline Template</label>
            <select class="form-control" name="timeline_id">
              <option value="">--- Select ---</option>
              @foreach($timelines as $t)
              <option value="{{ $t->id }}"
                @if( old('timeline_id') == $t->id )
                selected="selected"
                @endif>
                {{ $t->name }}
              </option>
              @endforeach
            </select>
            @if ($errors->has('timeline_id'))
            <span class="help-block">
              <strong>{{ $errors->first('timeline_id') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Copy Timeline</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection