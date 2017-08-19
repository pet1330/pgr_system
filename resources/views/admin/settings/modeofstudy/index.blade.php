@extends('layouts.dashboard')
@section('page_title', 'Modes Of Study')
@section('page_description', 'Current Modes Of Study')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-mode-of-study-table')
      <th>Modes Of Study</th>
      <th>Timing Factor</th>
      <th>Total Students</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new Mode Of Study</label>
        <form action="{{ route('admin.settings.mode-of-study.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-8">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <div class="form-group{{ $errors->has('timing_factor') ? ' has-error' : '' }} col-md-4">
            <input type="number" step="0.01" class="form-control" placeholder="Timing Factor" name="timing_factor" value="{{ old('timing_factor') }}">
            @if ($errors->has('timing_factor'))
              <span class="help-block">
                <strong>{{ $errors->first('timing_factor') }}</strong>
              </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Add Mode of Study</button>
        </form>
      </div>
    </div>
    @if($deletedModesofStudy->isNotEmpty())
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Modes of Study
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
              @foreach($deletedModesofStudy as $mos)
              <div class="col-md-12">
                <a href="{{ route('admin.settings.mode-of-study.restore', $mos->id) }}">
                  <span class="btn btn-success">Restore</span>
                </a>
                {{ $mos->name }}
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
