@extends('layouts.dashboard')
@section('page_title', $staff->name . '\'s Profile')
@section('page_description', '')
@section('content')
<div class="">
  @forelse($supervisees as $sup_type => $records)
  <h2>{{ $staff->supervisor_types($sup_type) }}</h2>
    @foreach($records as $sr)
    <div class="box box-primary">
        <div class="panel-body ">
          <div class="col-sm-3">
            <div class="hero-widget well well-sm">
              <div class="icon">
                <img src="{{ $sr->student->avatar(130) }}" class="img-circle"></img>
              </div>
              <div class="text">
                <label class="text-muted">{{ $sr->student->name }}</label>
              </div>
              <div class="options">
                <a href="{{ route('admin.student.show', [$sr->student->university_id]) }}" class="btn btn-default btn-lg">
                View Student</a>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hero-widget well well-sm{{ $sr->overdue_count ? ' text-danger' : '' }}">
              <div class="icon">
                <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var> {{ $sr->overdue_count }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">
                Overdue Milestones</span>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hero-widget well well-sm{{ $sr->amendments_count ? ' text-warning' : '' }}">
              <div class="icon">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $sr->amendments_count }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">Awaiting Amendments</span>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="hero-widget well well-sm{{ $sr->upcoming_count ? ' text-warning' : '' }}">
              <div class="icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $sr->upcoming_count }}</var>
                {{-- <label class="text-muted">total orders</label> --}}
              </div>
              <div class="options">
                <span class="btn btn-lg">Upcoming Milestones</span>
              </div>
            </div>
          </div>
        </div>
      </div>


    @endforeach
  @empty
  <div class="col-md-6 col-md-offset-3">
    <div class="box box-primary">
      <div class="box-body text-center">
        <h4>{{ ucfirst($staff->first_name) }} does not currently supervise any student</h4>
        <p>If you are a postgraduate student, please login with your student account</p>
      </div>
    </div>
  </div> -->
  @endforelse
</div>
@endsection