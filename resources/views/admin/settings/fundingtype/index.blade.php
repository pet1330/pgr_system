@extends('layouts.dashboard')
@section('page_title', 'Funding Types')
@section('page_description', 'Current list of funding types')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Funding Type</th>
              <th>Total</th>
              <th><i class="fa fa-gears"></i></th>
              <th><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
          <div id="confirm">
            @foreach($fundingtypes as $abs)
            <tr>
              <td>{{ $abs->name }}</td>
              <td>{{ $abs->students_count }}</td>
              <td>
                <form action="{{ route('settings.funding-type.index', $abs->id) }}" method="PATCH">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </form>
              </td>
              <td>
                <form
                  method="POST"
                  action="{{ route('settings.funding-type.destroy',$abs->id) }}"
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
          <form action="{{ route('settings.funding-type.store') }}" method="POST">
          {{ csrf_field() }}
                <label>Create new funding type</label>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>
              <button type="submit" class="btn btn-primary">Add Funding Type</button>
          </form> 
        </div>
    </div>
  </div>
</div>
@endsection
