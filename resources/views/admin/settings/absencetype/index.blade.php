@extends('layouts.dashboard')
@section('page_title', 'Absence Types')
@section('page_description', 'Current list of absence types')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Absence Type</th>
              <th>Interuption</th>
              <th>Current</th>
              <th>Total</th>
              <th colspan="2"><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
          <div id="confirm">
            @foreach($absencetypes as $abs)
            <tr>
              <td>{{ $abs->name }}</td>
              <td>{{ $abs->interuption ? 'Yes' : 'No' }}</td>
              <td>{{ $abs->currentabsence_count }}</td>
              <td>{{ $abs->absence_count }}</td>
              <td>
                <form action="{{ route('settings.absence-type.index', $abs->id) }}" method="PATCH">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </form>
              </td>
              <td>
                <form
                  method="POST"
                  action="{{ route('settings.absence-type.destroy',$abs->id) }}"
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
          <form action="{{ route('settings.absence-type.store') }}" method="POST">
              {{ csrf_field() }}
                <label>Create new absence type</label>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif

                @if ($errors->has('interuption'))
                  <span class="help-block">
                    <strong>{{ $errors->first('interuption') }}</strong>
                  </span>
                @endif
              </div>
                <div class="col-md-12">
                  {{-- <toggle
                  name="interuption"
                    :value="false"
                    :width="100"
                    :height="30"
                    :labels="{checked: 'Interupting', unchecked: 'Part of Study'}">
                  </toggle> --}}

                  <simple-toggle
                  name="interuption"
                    :value="false"
                    :width="100"
                    :height="30"
                    :labels="{checked: 'Interupting', unchecked: 'Part of Study'}">
                  </simple-toggle>
                  </div>
                  <div class="col-md-12">
              <button type="submit" class="btn btn-primary">Add Absence Type</button>
            </div>
            </form> 
            </div>
        </div>
    </div>
  </div>
</div>
@endsection
