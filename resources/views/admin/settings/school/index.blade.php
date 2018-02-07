@extends('layouts.dashboard')
@section('page_title', 'Schools')
@section('page_description', 'Current list of Schools')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-school-table')
    <th>Name</th>
    <th>College</th>
    <th>Total Students</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new School</label>
        <form action="{{ route('settings.school.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-4">
              <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
              @if ($errors->has('name'))
              <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('college_id') ? ' has-error' : '' }} col-md-4">
              <select class="form-control" name="college_id">
                <option value="">--- Select College ---</option>
                @foreach($colleges as $c)
                <option value="{{ $c->id }}"
                  @if( old('college_id') == $c->id )
                  selected="selected"
                  @endif>
                  {{ $c->name }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('college_id'))
              <span class="help-block">
                <strong>{{ $errors->first('college_id') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('notifications_address') ? ' has-error' : '' }} col-md-4">
              <input type="text" class="form-control" placeholder="Notifications Address" name="notifications_address" value="{{ old('notifications_address') }}">
              @if ($errors->has('notifications_address'))
              <span class="help-block">
                <strong>{{ $errors->first('notifications_address') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Add School</button>
        </form>
      </div>
    </div>
    @if($deletedSchools->count() > 0)
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Schools
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
            @foreach($deletedSchools as $s)
            <div class="col-md-12">
              <a href="{{ route('settings.school.restore', $s->id) }}">
                <span class="btn btn-success">Restore</span>
              </a>
              {{ $s->name }}
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