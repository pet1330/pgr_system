@extends('layouts.dashboard')
@section('page_title', 'Edit: '. $milestone->name)
@section('page_description', $student->student->name)
@section('content')
<div id="app">
  <section class="content">
    <div class="box box box-primary">
      <div class="box-body">
        <form action="{{ route('admin.student.milestone.update', [$student->id, $milestone->id]) }}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
          <div class="form-group{{ $errors->has('milestone_type') ? ' has-error' : '' }} col-md-6">
            <label for="milestone_type">Milestone Type</label>
            <select id="milestone_type" name="milestone_type" class="form-control">
                <option>{{ $errors->first('due') }}</option>
                @foreach ($types as $t)
                    <option value="{{ $t->id }}"
                    @if($errors->any())
                       {{ (collect(old('milestone_type'))->contains($t->id)) ? 'selected':'' }}  />
                    @else
                      {{ ($milestone->milestone_type->id == $t->id) ? 'selected':'' }} />
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
            <label for="due">Due On</label>
            <input type=date
                   class="form-control"
                   name="due"
                   value="{{ old('due') ?? $milestone->due_date->format('Y-m-d') }}">
            @if ($errors->has('due'))
            <span class="help-block">
              <strong>{{ $errors->first('due') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Add Milestone</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
@endsection
