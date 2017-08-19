@extends('layouts.dashboard')
@section('page_title', 'Update Programme')
@section('page_description', $programme->name)
@section('content')
    <div class="box box box-primary">
      <div class="box-body">
        <label>Update programme</label>
        <form action="{{ route('admin.settings.programmes.update', $programme->id) }}" method="POST">
        <input type="hidden" name="_method" value="PATCH">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $programme->name }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }} col-md-4" step="1">
            <input type="number" class="form-control" placeholder="Name" name="duration" value="{{ old('duration') ?? $programme->duration }}">
            @if ($errors->has('duration'))
            <span class="help-block">
              <strong>{{ $errors->first('duration') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Update Programme</button>
        </form>
      </div>
    </div>
@endsection