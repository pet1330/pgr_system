@extends('layouts.dashboard')
@section('page_title', $staff->name . '\'s Profile')
@section('page_description', '')
@section('content')
<div class="content">
  <style type="text/css">
  .hero-widget { text-align: center; padding-top: 20px; padding-bottom: 20px; }
  .hero-widget .icon { display: block; font-size: 96px; line-height: 96px; margin-bottom: 10px; text-align: center; }
  .hero-widget var { display: block; height: 64px; font-size: 64px; line-height: 64px; font-style: normal; }
  .hero-widget label { font-size: 17px; }
  .hero-widget .options { margin-top: 10px; }
  
  </style>
  @forelse($staff->supervising()->orderBy('supervisors.supervisor_type')->get() as $sr)
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
          <div class="hero-widget well well-sm{{ $sr->timeline()->overdue()->count() ? ' text-danger' : '' }}">
            <div class="icon">
              <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline()->overdue()->count() }}</var>
            </div>
            <div class="options">
              <span class="btn btn-lg">
                Overdue Milestones</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="hero-widget well well-sm{{ $sr->timeline()->upcoming()->count() ? ' text-warning' : '' }}">
            <div class="icon">
              <i class="fa fa-clock-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline()->upcoming()->count() }}</var>
              {{-- <label class="text-muted">total orders</label> --}}
            </div>
            <div class="options">
              <span class="btn btn-lg">Upcoming Milestones</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="hero-widget well well-sm{{ $sr->timeline()->recentlySubmitted()->count() ? ' text-success' : '' }}">
            <div class="icon">
              <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
            <div class="text">
              <var>{{ $sr->timeline()->recentlySubmitted()->count() }}</var>
            </div>
            <div class="options">
              <span class="btn btn-lg">Submitted Milestones</span>
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