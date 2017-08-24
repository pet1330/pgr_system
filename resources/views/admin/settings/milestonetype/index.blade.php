@extends('layouts.dashboard')
@section('page_title', 'Milestone Type')
@section('page_description', 'List of Milestone Types')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-milestone-type-table')
      <td>Milestone Type</td>
      <td>Duration (Days)</td>
      <td>Milestones</td>
      <td>Templates</td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new milestone type</label>
          <form action="{{ route('admin.settings.milestone-type.store') }}" method="POST">
          {{ csrf_field() }}
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
                  <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>

                <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }} col-md-4">
                  <input type="number" step="1" class="form-control" placeholder="Duration in Days" name="duration" value="{{ old('duration') }}">
                  @if ($errors->has('duration'))
                    <span class="help-block">
                      <strong>{{ $errors->first('duration') }}</strong>
                    </span>
                  @endif
                </div>
              <button type="submit" class="btn btn-primary">Add Milestone Type</button>
          </form>  
      </div>
    </div>
    @if($deletedMilestoneType->isNotEmpty())
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Milestone Types
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deletedMilestoneType as $dmt)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.milestone-type.restore', $dmt->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $dmt->name }}
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
