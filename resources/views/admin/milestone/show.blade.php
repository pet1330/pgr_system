@extends('layouts.dashboard')
@section('page_title', "")
{{-- @section('page_description', $milestone->usefulDate()->format('d m Y')) --}}
@section('content')
<div id="app">
  <div class="content">
    <div class="panel-body">
      <a  href="{{ route('admin.student.show', $student->student->university_id) }}">
        <span class="btn btn-default">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> Profile</span>
      </a>
      <a  href="{{ route('admin.student.milestone.edit', [$student->id, $milestone->slug()]) }}">
        <span class="btn btn-default pull-right">
        Edit This Milestone</span>
      </a>
    </div>
    {{ dump( $milestone->getAttributes() ) }}
    <div class="box box-primary">
      <div class="box-body">
        Name: {{ $milestone->name }} <br>
        Start Date: {{ $milestone->start_date->format('d/m/Y') }}<br>
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
      </div>
    </div>
    <div class="box box box-primary">
      <div class="box-body">
        @forelse($milestone->getMedia('submission')->reverse() as $file)
        <a href="{{ $file->getUrl() }}">
          @component('components.infobox')
          @if($file->id === $milestone->latestMedia('submission')->id)
          @slot('title', $file->original_name)
          @else
          @slot('colour', 'alert-warning')
          @endif
          @slot('icon', 'fa ' . $file->icon )
          {{ $file->created_at->format('g:ia') }}<br>
          {{ $file->created_at->format('jS F Y') }}
          @endcomponent
        </a>
        @empty
        This milestone has no previous submissions
        @endforelse
      </div></div>
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
                  <li>The upload must be a doc, docx, or pdf</li>
                </ul>
              </div>
              <div class="col-md-8">
                <form action="{{ route('student.upload', $milestone->slug()) }}" id="uploader" class="dropzone" method="POST" {{-- enctype="multipart/form-data" --}}>
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
    </div>
  </div>
  @endsection