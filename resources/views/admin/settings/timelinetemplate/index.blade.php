@extends('layouts.dashboard')
@section('page_title', 'Timeline Templates')
@section('page_description', 'List of timeline templates')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Timeline Name</th>
              <th>Number of Milestones</th>
              <th colspan="2"><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
          <div id="confirm">
            @foreach($templates as $template)
            <tr>
              <td>{{ $template->name }}</td>
              <td>{{ $template->milestone_templates_count }}</td>
            {{--   <td>
                <form action="{{ route('settings.milestone-type.index', $template->id) }}" method="PATCH">
                {{ csrf_field() }}
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                  </button>
                </form>
              </td>
              <td>
                <form
                  method="POST"
                  action="{{ route('settings.milestone-type.destroy',$template->id) }}"
                  accept-charset="UTF-8"
                  class="delete-form">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <click-confirm>
                      <i class="fa fa-trash"></i>
                    </click-confirm>
                </form>
              </td> --}}
            </tr>
            @endforeach
            </div>
          </tbody>
        </table>
        {{--  --}}
          <h2>Create a new Milestone Type</h2>
          <form action="#{{-- {{ route('settings.template-template.store') }} --}}" method="POST">
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
  </div>
</div>
@endsection
