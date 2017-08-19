@extends('layouts.dashboard')
@section('page_title', 'Update Mode of Study')
@section('page_description', $modeOfStudy->name)
@section('content')
    <div class="box box box-primary">
      <div class="box-body">
        <label>Update Mode of Study</label>
        <form action="{{ route('admin.settings.mode-of-study.update', $modeOfStudy->id) }}" method="POST">
        <input type="hidden" name="_method" value="PATCH">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $modeOfStudy->name }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('timing_factor') ? ' has-error' : '' }} col-md-4" step="0.01">
            <input type="number" class="form-control" placeholder="Name" name="timing_factor" value="{{ old('timing_factor') ?? $modeOfStudy->timing_factor }}">
            @if ($errors->has('timing_factor'))
            <span class="help-block">
              <strong>{{ $errors->first('timing_factor') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Update Mode of Study</button>
        </form>
      </div>
    </div>
</form>
@endsection