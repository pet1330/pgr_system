@extends('layouts.dashboard')
@section('page_title', $staff->name . '\'s Profile')
@section('page_description', '')
@section('content')
<div class="content">
  @forelse($staff->supervising()->with('timeline')->orderBy('supervisors.supervisor_type')->get() as $sr)
  <div class="row">
    <div class="box box-primary">
      <div class="panel-body ">
        <div class="col-sm-3">
          <div class="hero-widget well well-sm">
            <div class="icon">
              <img src="{{ $sr->student->avatar(130) }}" class="img-circle"></img>
            </div>
            <div class="text">
              <label class="text-muted">{{ $sr->student->name }}</label>
              {{-- <label class="text-muted">Submitted Milestones</label> --}}
            </div>
            <div class="options">
              <a href="{{ route('admin.student.show', [$sr->student->university_id]) }}" class="btn btn-default btn-lg">
              View Student</a>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="hero-widget well well-sm{{ $sr->timeline->filter->isOverdue()->count() ? ' text-danger' : '' }}">
            <div class="icon">
              <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline->filter->isOverdue()->count() }}</var>
            </div>
            <div class="options">
              <span class="btn btn-lg">
              Overdue Milestones</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="hero-widget well well-sm{{ $sr->timeline->filter->isAwaitingAmendments()->count() ? ' text-warning' : '' }}">
            <div class="icon">
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline->filter->isAwaitingAmendments()->count() }}</var>
            </div>
            <div class="options">
              <span class="btn btn-lg">Awaiting Amendments</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="hero-widget well well-sm{{ $sr->timeline->filter->isUpcoming()->count() ? ' text-warning' : '' }}">
            <div class="icon">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline->filter->isUpcoming()->count() }}</var>
              {{-- <label class="text-muted">total orders</label> --}}
            </div>
            <div class="options">
              <span class="btn btn-lg">Upcoming Milestones</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @empty
  <div class="col-md-6 col-md-offset-3">
    <div class="box box-primary">
      <div class="box-body text-center">
        <h4>{{ ucfirst($staff->first_name) }} does not currently supervise any student</h4>
      </div>
    </div>
  </div>
  @endforelse
</div>
@endsection