@extends('layouts.dashboard')
@section('page_title', 'Milestone Template: ' . $milestone->type->name)
@section('page_description', $timeline->name)
@section('content')
<div id="app">
  <div class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <label>Update Milestone</label>
        <form action="{{ route('settings.timeline.milestone.update',
        [$timeline->slug(), $milestone->slug()]) }}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
          <div class="form-group{{ $errors->has('milestone_type') ? ' has-error' : '' }} col-md-6">
            <select class="form-control" name="milestone_type">
              <option value="">--- Select ---</option>
              @foreach($types as $t)
              <option value="{{ $t->id }}"
                @if($errors->any())
                {{ (collect(old('milestone_type'))->contains($t->id)) ? 'selected':'' }}/>
                @else
                {{ ($milestone->type->id == $t->id) ? 'selected':'' }}/>
                @endif
                {{ $t->name }}
              </option>
              @endforeach
            </select>
            @if ($errors->has('milestone_type'))
            <span class="help-block">
              <strong>{{ $errors->first('milestone_type') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('due') ? ' has-error' : '' }} col-md-6">
            <input type="number" step="1" placeholder="Due After (months)" class="form-control" name="due" value="{{ old('due') ?? $milestone->due }}">
            @if ($errors->has('due'))
            <span class="help-block">
              <strong>{{ $errors->first('due') }}</strong>
            </span>
            @endif
          </div>
            <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary">Add Milestone</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection