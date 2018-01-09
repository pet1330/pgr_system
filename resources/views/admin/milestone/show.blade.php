@extends('layouts.dashboard')
@section('page_title', $milestone->name)
@section('page_description', $milestone->usefulDate()->format('d/m/ Y'))
@section('content')
<div id="app">
  <div class="content">
    <div class="panel-body">
      <a  href="{{ route('admin.student.record.show', [$student->university_id, $record->slug()]) }}">
        <span class="btn btn-default">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> Profile</span>
      </a>
      @can('manage', $milestone)
      <a  href="{{ route('admin.student.record.milestone.edit',
        [$student->university_id, $record->slug(), $milestone->slug()]) }}">
        <span class="btn btn-default pull-right">
        Edit This Milestone</span>
      </a>
      @endcan
    </div>
    <div class="box box-primary">
      <div class="box-body">
        Name: {{ $milestone->name }} <br>
        @if( $milestone->duration )
        Start Date: {{ $milestone->start_date->format('d/m/Y') }}<br>
        @endif
        Due Date: {{ $milestone->due_date->format('d/m/Y') }} <br>
        @if($milestone->submitted_date)
        Submitted Date: {{ $milestone->submitted_date->format('d/m/Y') }}<br>
        @endif
        @if($milestone->isRecentlysubmitted())
        <h4><span class="label label-success">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isOverdue())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isPreviouslySubmitted())
        <h4><span class="label label-success">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isUpcoming())
        <h4><span class="label label-warning">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isFuture())
        <h4><span class="label label-primary">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isAwaitingAmendments())
        <h4><span class="label label-warning">{{ $milestone->status_for_humans }}</span></h4>
        @endif
        @if($milestone->isApproved())
        <h4><span class="label label-success">{{ $milestone->status_for_humans }}</span></h4>
        @endif
      </div>
    </div>
    @can('manage', App\Models\Approval::class)
    <div class="box box-primary">
      <div class="box-body">
        <form action="{{ route('admin.student.record.milestone.approve',
          [$student->university_id, $record->slug(), $milestone->slug()]) }}" method="POST">
          {{ csrf_field() }}
          <div class="col-md-7">
            <div class="input-group">
              <div class="input-group-addon">Feedback (optional)</div>
              <input type="text" name="feedback" class="form-control" value="{{ old('feedback') }}">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group{{ $errors->has('approved') ? ' has-error' : '' }}">
              <select class="form-control col-md-4" name="approved">
                <option value="">--- Select ---</option>
                <option value="1"><i class="fa fa-check" aria-hidden="true"></i> Accept</option>
                <option value="0"><i class="fa fa-times" aria-hidden="true"></i> Reject</option>
              </select>
              @if ($errors->has('approved'))
              <span class="help-block">
                <strong>{{ $errors->first('approved') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <button class="btn btn-default col-md-2">Approve Milestone</button>
        </form>
      </div>
    </div>
    @endcan
    @if($milestone->approvals->isNotEmpty())
    <div class="box box-primary">
      <div class="box-body">
        <label>Approval History:</label><br>
        @foreach($milestone->approvals as $a)
        @if($a->approved)
        <span data-toggle="tooltip" title="Feedback: {{ $a->reason ?? '[ None Provided ]' }}" class="btn btn-success col-md-4 text-center"><i class="fa fa-check" aria-hidden="true"></i> Accepted by {{ $a->approved_by->name }} {{ $a->created_at->format('g:ia d/m/y') }}</span>
        @else
        <span data-toggle="tooltip" title="Feedback: {{ $a->reason ?? '[ None Provided ]' }}" class="btn btn-danger col-md-4 text-center"><i class="fa fa-times" aria-hidden="true"></i> Rejected by {{ $a->approved_by->name }} {{ $a->created_at->format('g:ia - d/m/y') }}</span>
        @endif
        @endforeach
      </div>
    </div>
    @endif
    <div class="box box box-primary">
      <div class="box-body">
        @forelse($milestone->getMedia('submission')->reverse() as $file)
        <a href="{{ route('admin.student.record.milestone.media',
          [$student->university_id, $record->slug(), $milestone->slug(), $file->slug()]) }}">
          @component('components.infobox')
          @if($file->id !== $milestone->lastMedia('submission')->id)
          @slot('colour', 'alert-warning')
          @endif
          @slot('icon', 'fa ' . $file->icon )
          @slot('title', '')
          {{ $file->original_filename }}<br>
          {{ $file->created_at->format('g:ia') }}<br>
          {{ $file->created_at->format('jS F Y') }}<br>
          {{ $file->uploader->name }}
          @endcomponent
        </a>
        @empty
        This milestone has no previous submissions
        @endforelse
      </div>
    </div>
    @can('upload', $milestone)
    <div class="box box box-primary">
      <div class="box-body">
        <div class="panel-heading">
          <h4 class="panel-title">
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">Add a submission
          </a>
          </h4>
        </div>
        <div id="collapseone" class="panel-collapse collapse">
          <div class="panel-body">
            <div class="controls col-md-4">
              When submitting a form please ensure the following:
              <ul>
                <li>Only upload a single file</li>
                <li>The upload must be smaller than 20Mb</li>
                <li>The upload must be a Word, Excel or PDF</li>
              </ul>
            </div>
            <div class="col-md-8">
              <form action="{{ route('admin.student.record.milestone.upload',
                [$student->university_id, $record->slug(), $milestone->slug()]) }}" id="uploader" class="dropzone" method="POST">
                <div class="dz-progress progress" style="background-color: inherit;">
                  <span class="dz-upload" data-dz-uploadprogress></span>
                  <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                </div>
                {{ csrf_field() }}
                <div class="fallback">
                  <input name="file" type="file" multiple="" />
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection