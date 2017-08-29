@extends('layouts.dashboard')
@section('page_title', $timeline->name)
@section('page_description', "")
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-milestone-template-table')
    <th>Name</th>
    <th>Due After</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Add a Milestone</label>
        <form action="{{ route('admin.settings.timeline.milestone.store', $timeline->id) }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('milestone_type') ? ' has-error' : '' }} col-md-6">
            {{-- <label for="milestone_type">Milestone Type</label> --}}
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
          <div class="form-group{{ $errors->has('due') ? ' has-error' : '' }} col-md-6">
            {{-- <label for="due">Due After (months)</label> --}}
            <input type="number" step="1" placeholder="Due After (months)" class="form-control" name="due" value="{{ old('due') }}">
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
    @if($deleted_milestones->count() > 0)
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Milestones
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deleted_milestones as $dms)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.timeline.milestone.store', $dms->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $dms->name }}
              </div>
                @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</li>
@endsection
