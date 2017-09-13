<div class="panel-body row">
  <div class="dropdown pull-right">
    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Manage Student
    <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
    @can('create', App\Models\Absence::class)
      <li role="presentation">
        <a role="menuitem" href="{{ route('admin.student.absence.create', $student->university_id) }}">
          Create New Absence
        </a>
      </li>
      @endcan
      <li role="presentation">
        <a role="menuitem" href="{{ route('admin.student.record.milestone.create',
          [$student->university_id, $record->slug()]) }}">
          Create New Milestone
        </a>
      </li>
      <li role="presentation">
        <a role="menuitem" href="{{ route('admin.student.record.supervisor.create',
          [$student->university_id, $record->slug()]) }}">
          Add Supervisor
        </a>
      </li>
      <li role="separator" class="divider"></li>
      <li role="presentation">
        <a role="menuitem" href="{{ route('admin.student.record.edit', [$student->university_id, $record->slug()]) }}">
          Edit Student Record
        </a>
      </li>
    </ul>
  </div>
</div>
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
        <a href="{{ route('admin.student.record.milestone.show',
          [$student->university_id, $record->slug(), $m->slug()]) }}">
          <li class="col-md-12 list-unstyled">
            <span class="fa-stack fa-md" style="margin-right: 20px;">
              <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
              <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}
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
        <a href="{{ route('admin.student.record.milestone.show',
          [$student->university_id, $record->slug(),$m->slug()]) }}">
          <li class="col-md-12 list-unstyled">
            <span class="fa-stack fa-md" style="margin-right: 20px;">
              <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
              <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}
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
      You have no upcoming or or overdue milestones! Congrats!
    </div>
    @endif
    <div class="panel-body text-center">
      <a  href="{{ route('admin.student.record.milestone.index', [$student->university_id, $record->slug()]) }}">
        <span class="btn btn-default">
          View All Milestones
        </span>
      </a>
    </div>
  </div>
  @if($record->supervisors->isNotEmpty())
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">
      Supervisors
      </h3>
    </div>
    <div class="box-body text-center">
      @component('components.supervisor')
      @slot('title', 'Director of Study')
      @slot('supervisor', $record->DirectorOfStudy)
      @endcomponent
      
      @component('components.supervisor')
      @slot('title', 'Second Supervisor')
      @slot('supervisor', $record->secondSupervisor)
      @endcomponent
      
      @component('components.supervisor')
      @slot('title', 'Third Supervisor')
      @slot('supervisor', $record->thirdSupervisor)
      @endcomponent
    </div>
  </div>
  @endif
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
            <td>Mode of Study:</td>
            <td>{{ $record->modeOfStudy->name }}</td>
          </tr>
          <tr>
            <td>Programme:</td>
            <td>{{ $record->programme->name }}</td>
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
      <table class="table">
        <thead>
          <td>From</td>
          <td>To</td>
          <td>Duration</td>
          <td>Absence Type</td>
        </thead>
        <tbody>
          @foreach($student->absences->sortBy('from') as $a)
          <tr>
            <td>{{ $a->from->format('d/m/Y') }}</td>
            <td>{{ $a->to->format('d/m/Y') }}</td>
            <td>{{ $a->duration }}</td>
            <td>{{ $a->type->name }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @else
  <div class="box box-primary">
    <div class="box-body text-center">
      You have no absences!
    </div>
    <div class="panel-body text-center">
      <a  href="{{ route('admin.student.record.milestone.index', [$student->university_id, $record->slug()]) }}">
      </a>
    </div>
  </div>
  @endif
</div>