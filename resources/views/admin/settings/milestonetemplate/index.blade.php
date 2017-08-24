@extends('layouts.dashboard')
@section('page_title', 'Timeline Templates')
@section('page_description', 'List of timeline templates')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-timeline-template-table')
      <th>Name</th>
      <th>Milestone Count</th>
      <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
      <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new Enrolment Statuses</label>
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
    @if($deleted_timeline_templates->isNotEmpty())
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Timeline Templates
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deleted_timeline_templates as $tt)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.timeline-template.restore', $tt->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $tt->Name }}
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
