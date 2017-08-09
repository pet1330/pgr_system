@extends('layouts.dashboard')
@section('page_title', 'Modes Of Study')
@section('page_description', 'Current Modes Of Study')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Modes Of Study</th>
              <th>Timing Factor</th>
              <th>Total Students</th>
              <th colspan="2"><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
          <div id="confirm">
            @foreach($modes as $mos)
            <tr>
              <td>{{ $mos->name }}</td>
              <td>{{ $mos->timing_factor }}</td>
              <td>{{ $mos->student_record_count }}</td>
              <td>
                <form action="{{ route('settings.mode-of-study.index', $mos->id) }}" method="PATCH">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </form>
              </td>
              <td>
                <form
                  method="POST"
                  action="{{ route('settings.mode-of-study.destroy',$mos->id) }}"
                  accept-charset="UTF-8"
                  class="delete-form">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <click-confirm>
                      <i class="fa fa-trash"></i>
                    </click-confirm>
                </form>
              </td>
            </tr>
            @endforeach
            </div>
          </tbody>
        </table>
        <h2>Create a new Mode of Study</h2>
          <form action="{{ route('settings.mode-of-study.store') }}" method="POST">
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
  </div>
</div>
@endsection
