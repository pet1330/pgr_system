@extends('layouts.dashboard')
@section('page_title', 'Enrolment Statuses')
@section('page_description', 'Current list of Enrolment Statuses')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Enrolment Status</th>
              <th>Total Students</th>
              <th><i class="fa fa-gears"></i></th>
              <th><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
          <div id="confirm">
            @foreach($enrolments as $enrol)
            <tr>
              <td>{{ $enrol->status }}</td>
              <td>{{ $enrol->students_count }}</td>
              <td>
                <form action="{{ route('settings.enrolments.index', $enrol->id) }}" method="PATCH">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </form>
              </td>
              <td>
                <form
                  method="POST"
                  action="{{ route('settings.enrolments.destroy',$enrol->id) }}"
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
          <form action="{{ route('settings.enrolments.store') }}" method="POST">
          {{ csrf_field() }}
                <label>Create a new Enrolment Status</label>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Status" name="status" value="{{ old('status') }}">
                @if ($errors->has('status'))
                  <span class="help-block">
                    <strong>{{ $errors->first('status') }}</strong>
                  </span>
                @endif
              </div>
              <button type="submit" class="btn btn-primary">Add Enrolment Status</button>
          </form> 
        </div>
    </div>
  </div>
</div>
@endsection
