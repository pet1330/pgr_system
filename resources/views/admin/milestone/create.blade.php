@extends('layouts.dashboard')
@section('page_title', 'Create New Milestone')
@section('page_description', $student->name)
@section('content')
<div id="app">
  <section class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <form id="studentUploaderForm" action="{{ route('admin.student.record.milestone.store',
          [$student->university_id, $record->slug()]) }}" enctype="multipart/form-data" method="POST">
          <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
          <div class="form-group{{ $errors->has('milestone_type') ? ' has-error' : '' }} col-md-7">
            <label for="milestone_type">Milestone Type</label>
            <select class="form-control" name="milestone_type">
              <option value="">--- Select ---</option>
              @foreach($types as $t)
              <option value="{{ $t->id }}"
                @if( old('milestone_type') == $t->id )
                selected="selected"
                @endif>
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
          @can('manage', App\Models\Milestone::class)
            <div class="form-group{{ $errors->has('due') ? ' has-error' : '' }} col-md-5">
              <label for="due">Due On</label>
              <input type="date" class="form-control" name="due" value="{{ old('due') }}">
              @if ($errors->has('due'))
              <span class="help-block">
                <strong>{{ $errors->first('due') }}</strong>
              </span>
              @endif
            </div>
          @else
          <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }} col-md-5">
            <label for="file">Submission</label>
            <input type="file" class="form-control" name="file" value="{{ old('file') }}">
            @if ($errors->has('file'))
            <span class="help-block">
              <strong>{{ $errors->first('file') }}</strong>
            </span>
            @endif
          </div>
          @endcan
          <div class="form-group col-md-12">
            <button type="submit" class="btn btn-primary" id="submit-all">Add Milestone</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection