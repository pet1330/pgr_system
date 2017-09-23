@extends('layouts.dashboard')
@section('page_title', $admin->name)
@section('page_description', 'Dashboard')
@section('content')
{{-- Main content --}}
    <div class="box box-primary">
      <div class="panel-body ">
        <div class="col-md-3 col-sm-6">
          <a href="{{ route('admin.student.amendments') }}">
            <div class="hero-widget well well-sm{{ $awaitingAmendments ? ' text-warning' : ' text-muted' }}">
              <div class="icon">
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $awaitingAmendments }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">
                Awaiting Amendments</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="{{ route('admin.student.upcoming') }}">
            <div class="hero-widget well well-sm{{ $upcoming ? ' text-warning' : ' text-muted' }}">
              <div class="icon">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $upcoming }}</var>
                {{-- <label class="text-muted">total orders</label> --}}
              </div>
              <div class="options">
                <span class="btn btn-lg">Upcoming Milestones</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="{{ route('admin.student.overdue') }}">
            <div class="hero-widget well well-sm{{ $overdue ? ' text-danger' : ' text-muted' }}">
              <div class="icon">
                <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $overdue }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">Overdue</span>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-3 col-sm-6">
          <a href="{{ route('admin.student.submitted') }}">
            <div class="hero-widget well well-sm{{ $recentlySubmitted ? ' text-success' : ' text-muted' }}">
              <div class="icon">
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ $recentlySubmitted }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">Recently Submitted</span>
              </div>
            </div>
          </a>
        </div>
        @can('view', App\Models\Student::class)
        <div class="col-sm-6">
          <a href="{{ route('admin.student.index') }}">
            <div class="hero-widget well well-sm text-muted">
              <div class="icon">
                <i class="fa fa-graduation-cap" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ App\Models\StudentRecord::count() }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">
                All Students</span>
              </div>
            </div>
          </a>
        </div>
        @endcan
        @can('view', App\Models\Staff::class)
        <div class="col-sm-6">
          <a href="{{ route('admin.staff.index') }}">
            <div class="hero-widget well well-sm text-muted">
              <div class="icon">
                <i class="fa fa-user" aria-hidden="true"></i>
              </div>
              <div class="text">
                <var>{{ App\Models\Staff::count() }}</var>
              </div>
              <div class="options">
                <span class="btn btn-lg">
                All Staff</span>
              </div>
            </div>
          </a>
        </div>
        @endcan
      </div>
    </div>


@if(auth()->user()->university_id === 'plightbody')
    @component('components.infobox')
    @slot('title', 'students')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Student::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'staff')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Staff::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Admins')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Admin::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'programmes')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Programme::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Study Modes')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\ModeOfStudy::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'funding types')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\FundingType::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'schools')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\School::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'colleges')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\College::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Student Records')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\StudentRecord::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Milestone Types')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\MilestoneType::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Milestones')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Milestone::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Milestone Templates')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\MilestoneTemplate::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Timeline Templates')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\TimelineTemplate::count() }}
    @endcomponent
    @component('components.infobox')
    @slot('title', 'This Admin')
    @slot('icon', 'fa fa-gear')
    {{ $admin->university_id ?? "Unknown Admin" }} ({{ $admin->id ?? "Unknown Admin" }})
    @endcomponent
    @component('components.infobox')
    @slot('title', 'Approvals')
    @slot('icon', 'fa fa-gear')
    {{ App\Models\Approval::count() }}
    @endcomponent
    </div>
  </div>
    @endif
@endsection