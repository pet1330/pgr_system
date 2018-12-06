@extends('layouts.dashboard')
@section('page_title', 'Update Timeline')
@section('page_description', $timeline->name)
@section('content')
<div class="box box box-primary">
    <div class="box-body">
        <label>Update Timeline</label>
            <form action="{{ route('settings.timeline.update', $timeline->slug()) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PATCH">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
                    <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name', $timeline->name) }}">
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
@endsection