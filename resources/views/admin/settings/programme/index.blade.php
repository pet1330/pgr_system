@extends('layouts.dashboard')
@section('page_title', 'Programmes')
@section('page_description', 'Current list of Programmes')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-programme-table')
      <th>Programmes</th>
      <th>Duration (Months)</th>
      <th>Total Students</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new programme</label>
        <form action="{{ route('admin.settings.programmes.store') }}" method="POST">
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
            <input type="number" step="1" class="form-control" placeholder="Duration in Months" name="duration" value="{{ old('duration') }}">
            @if ($errors->has('duration'))
              <span class="help-block">
                <strong>{{ $errors->first('duration') }}</strong>
              </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Add Programme</button>
        </form>
      </div>
    </div>
    @if($deletedProgrammes->count() > 0)
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Programmes
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deletedProgrammes as $progs)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.programmes.restore', $progs->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $progs->name }}
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
