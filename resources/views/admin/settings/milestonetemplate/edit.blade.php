@extends('layouts.dashboard')
@section('page_title', 'Milestone Template: ' . $milestone->$type->name)
@section('page_description', $timeline->name)
@section('content')
<div id="app">
    <div class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new Timeline Template</label>
        <form action="{{ route('admin.settings.timeline.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Create New Timeline Template</button>
        </form>
      </div>
    </div>

    </div>
</div>
@endsection