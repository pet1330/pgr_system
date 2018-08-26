@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="content">
@can('manage', App\Models\Student::class)
<div class="panel-body row">
  <div class="dropdown pull-right">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
    Manage Student
    <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
      @can('manage', App\Models\Absence::class)
      <li role="presentation">
        <a role="menuitem" href="{{ route('student.absence.create', $student->university_id) }}">
          Create New Absence
        </a>
      </li>
      @endcan
      @can('manage', App\Models\Milestone::class)
      <li role="presentation">
        <a role="menuitem" href="{{ route('student.record.milestone.create',
          [$student->university_id, $record->slug()]) }}">
          Create New Milestone
        </a>
      </li>
      @endcan
      @can('manage', App\Models\Staff::class)
      <li role="presentation">
        <a role="menuitem" href="{{ route('supervisor.find',
          [$student->university_id, $record->slug()]) }}">
          Add Supervisor
        </a>
      </li>
      @endcan
      @can('manage', App\Models\Student::class)
      <li role="separator" class="divider"></li>
      <li role="presentation">
        <a role="menuitem" href="{{ route('student.record.edit',
          [$student->university_id, $record->slug()]) }}">
          Edit Student Record
        </a>
      </li>
      @can('manage', App\Models\Milestone::class)
      @can('manage', App\Models\Student::class)
      <li role="presentation">
        <a role="menuitem" href="{{ route('student.record.mass-assignment',
          [$student->university_id, $record->slug()]) }}">
          Assign Regularisation
        </a>
      </li>
      @endcan
      @endcan
      @can('manage', App\Models\Milestone::class)
      @can('manage', App\Models\Student::class)
      <li role="separator" class="divider"></li>
      <li role="presentation">
        <form method="POST" action="{{ route('student.record.destroy',
          [$student->university_id, $record->slug()]) }}" accept-charset="UTF-8" class="form-main">
              <input type="hidden" name="_method" value="DELETE">
              {{ csrf_field() }}
            <button class="btn btn-link" type="submit" role="menuitem" onclick="return confirm('Are you sure?')"
            style="color: #777;display: block; padding: 3px 20px; clear: both; font-weight: normal; line-height: 1.42857143; white-space: nowrap;">
              <center>Archive Record</center>
            </button>
        </form>
      </li>
      @endcan
      @endcan
      @endcan
    </ul>
  </div>
</div>
@endcan
<div class="col-md-6">
  @if($overdue->isNotEmpty())
  <div class="panel panel-danger">
    <div class="panel-heading">
      <h3 class="panel-title">
      Overdue Milestones
      </h3>
    </div>
    <div class="panel-body">
      <ul>
        @foreach($overdue->sortBy('due_date') as $m)
        <a href="{{ route('student.record.milestone.show',
          [$student->university_id, $record->slug(), $m->slug()]) }}">
          <li class="col-md-12 list-unstyled">
            <span class="fa-stack fa-md" style="margin-right: 20px;">
              <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
              <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">
              {{ $m->due_date->format('d/m') }}
              </strong>
            </span>
            {{ $m->name }}
          </li>
        </a>
        @endforeach
      </ul>
    </div>
  </div>
  @endif

  @if($awaiting->isNotEmpty())
  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3 class="panel-title">
      Awaiting Amendments
      </h3>
    </div>
    <div class="panel-body">
      <ul>
        @foreach($awaiting->sortBy('due_date') as $m)
        <a href="{{ route('student.record.milestone.show',
          [$student->university_id, $record->slug(), $m->slug()]) }}">
          <li class="col-md-12 list-unstyled">
            <span class="fa-stack fa-md" style="margin-right: 20px;">
              <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
              <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">
              {{ $m->due_date->format('d/m') }}
              </strong>
            </span>
            {{ $m->name }}
          </li>
        </a>
        @endforeach
      </ul>
    </div>
  </div>
  @endif

  @if($upcoming->isNotEmpty())
  <div class="panel panel-warning">
    <div class="panel-heading">
      <h3 class="panel-title">
      Upcoming Milestones
      </h3>
    </div>
    <div class="panel-body">
      <ul>
        @foreach($upcoming as $m)
        <a href="{{ route('student.record.milestone.show',
          [$student->university_id, $record->slug(),$m->slug()]) }}">
          <li class="col-md-12 list-unstyled">
            <span class="fa-stack fa-md" style="margin-right: 20px;">
              <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
              <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">
              {{ $m->due_date->format('d/m') }}
              </strong>
            </span>
            {{ $m->name }}
          </li>
        </a>
        @endforeach
      </ul>
    </div>
  </div>
  @endif
  <div class="box box-primary">
    @if($overdue->isEmpty() && $upcoming->isEmpty())
    <div class="box-body text-center">
      @if(auth()->id() === $student->id)
      You have no upcoming or or overdue milestones! Congrats!
      @else
      This student has no upcoming or overdue milestones
      @endif
    </div>
    @endif
    <div class="panel-body text-center">
      <a  href="{{ route('student.record.milestone.index',
        [$student->university_id, $record->slug()]) }}">
        <span class="btn btn-default">
          View All Milestones
        </span>
      </a>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">
      Supervisors
      </h3>
    </div>
    <div class="box-body text-center">
      @forelse($record->supervisors->sortBy('pivot.supervisor_type') as $sup)
      @component('components.supervisor')
      @slot('title', $sup->supervisor_types($sup->pivot->supervisor_type))
      @slot('supervisor', $sup)
      @slot('student', $student)
      @slot('record', $record)
      @endcomponent
      @empty
      @if(auth()->id() === $student->id)
      You have not been assigned a supervisor
      @else
      No supervisors have been assigned to this student
      @endif
      @endforelse
    </div>
  </div>
</div> {{-- end of left column --}}
<div class="col-md-6">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">User information</h3>
    </div>
    <div class="panel-body">
      <table class="table">
        <tbody>
          <tr>
            <td>Name:</td>
            <td>{{ $student->name }}</td>
          </tr>
          <tr>
            <td>Email:</td>
            <td>{{ $student->university_email }}</td>
          </tr>
          <tr>
            <td>University ID:</td>
            <td>{{ $student->university_id }}</td>
          </tr>
          <tr>
            <td>Current Year:</td>
            <td>{{ $record->enrolment_date->diffInYears()+1 }}</td>
          </tr>
          <tr>
            <td>Enrolled:</td>
            <td>{{ $record->enrolment_date->format('d/m/Y') }}</td>
          </tr>
          <tr>
            <td>School:</td>
            <td>{{ $record->school->name }}</td>
          </tr>
          <tr>
            <td>Enrolment Status:</td>
            <td>{{ $record->enrolmentStatus->status }}</td>
          </tr>
          <tr>
            <td>Student Status:</td>
            <td>{{ $record->studentStatus->status }}</td>
          </tr>
          <tr>
            <td>Programme:</td>
            <td>{{ $record->programme->name }}</td>
          </tr>
          <tr>
            <td>Is Tier Four:</td>
            <td>{{ $record->tierFour ? 'Yes' : 'No' }}</td>
          </tr>
          <tr>
            <td>Funding Type:</td>
            <td>{{ $record->fundingType->name }}</td>
          </tr>
          <tr>
            <td>Max End Date:</td>
            <td>{{ $record->end->format('d/m/Y') }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  @if($student->absences->isNotEmpty())
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Absences</h3>
    </div>
    <div class="panel-body">
      @can('manage', App\Models\Absence::class)
      <table class="table table-striped table-bordered" id="admin-absences-table" width="100%">
        <thead>
          <tr>
            <td>From</td>
            <td>To</td>
            <td>Duration</td>
            <td>Type</td>
            <td><i class="fa fa-cogs" aria-hidden="true"></i></td>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      @else
      <table class="table table-striped table-bordered" id="student-absences-table" width="100%">
        <thead>
          <tr>
            <td>From</td>
            <td>To</td>
            <td>Duration</td>
            <td>Type</td>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      @endcan
    </div>
  </div>
  @else
  <div class="box box-primary">
    <div class="box-body text-center">
      @if(auth()->id() === $student->id)
      You have no absences
      @else
      This student has no absences
      @endif
    </div>
    <div class="panel-body text-center">
      <a  href="{{ route('student.record.milestone.index',
        [$student->university_id, $record->slug()]) }}">
      </a>
    </div>
  </div>
  @endif
  @can('view', App\Models\Note::class)
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Notes <small>( not visable to students )</small>
          @cannot('manage', App\Models\Note::class)
            <div class="pull-right panel-title"><small>Read Only</small></div>
          @endcan
        </h3>

      </div>
      <div class="panel-body">
      <p @can('manage', App\Models\Note::class) id="note" @endcan class="note">{{ trim($record->note->content) }}</p>
      </div>
    </div>
  @endcan
</div>
</div>
</div>
@endsection