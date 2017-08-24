@extends('layouts.dashboard')
@section('page_title', $milestone->name)
@section('page_description', $milestone->usefulDate()->format('d m Y'))
@section('content')
<div id="app">
  <section class="content">

<div class="panel-body">
  <a  href="{{ route('admin.student.show', $student->student->university_id) }}">
    <span class="btn btn-default">
      <i class="fa fa-arrow-left" aria-hidden="true"></i> Profile</span>
  </a>
  <a  href="{{ route('admin.student.milestone.edit', [$student->id, $milestone->id]) }}">
    <span class="btn btn-default pull-right">
      Edit This Milestone</span>
  </a>
</div>

    {{ dump( $milestone->getAttributes() ) }}

    @if($milestone->isRecentlysubmitted())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
    @endif
    @if($milestone->isOverdue())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
    @endif
    @if($milestone->isPreviouslySubmitted())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
    @endif
    @if($milestone->isUpcoming())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
    @endif
    @if($milestone->isFuture())
        <h4><span class="label label-danger">{{ $milestone->status_for_humans }}</span></h4>
    @endif


  </section>
</div>
@endsection
 