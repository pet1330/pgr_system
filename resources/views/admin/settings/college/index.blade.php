@extends('layouts.dashboard')
@section('page_title', 'Colleges')
@section('page_description', 'Current list of Colleges')
@section('content')
<div class="content">
  <div class="col-md-12">
    @component('components.datatable')
    @slot('tableId', 'admin-college-table')
    <th>Colleges</th>
    <th>Schools</th>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
    @endcomponent
    <div class="box box box-primary">
      <div class="box-body">
        <label>Create new College</label>
        <form action="{{ route('settings.college.store') }}" method="POST">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Add College</button>
        </form>
      </div>
    </div>
    @if($deletedColleges->count() > 0)
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Show Deleted Colleges
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
            @foreach($deletedColleges as $c)
            <div class="col-md-12">
              <a href="{{ route('settings.college.restore', $c->slug()) }}">
                <span class="btn btn-success">Restore</span>
              </a>
              {{ $c->name }}
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