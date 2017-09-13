@extends('layouts.dashboard')
@section('page_title', 'Update College')
@section('page_description', $college->name)
@section('content')
    <div class="box box box-primary">
      <div class="box-body">
        <label>Update Colege</label>
        <form action="{{ route('admin.settings.college.update', $college->id) }}" method="POST">
        <input type="hidden" name="_method" value="PATCH">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $college->name }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Update College</button>
        </form>
      </div>
    </div>
@endsection