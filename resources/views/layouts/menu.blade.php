<ul class="sidebar-menu">
  <li class="header">MAIN MENU</li>
  <li>
    <a href="{{ route('home') }}">
      <i class="fa fa-dashboard" aria-hidden="true"></i>
      <span>Dashboard</span>
    </a>
  </li>
  @can('view', App\Models\Milestone::class)
  <li class="treeview">
    <a href="#">
      <i class="fa fa-bookmark" aria-hidden="true"></i>
      <span>Milestones</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="{{ route('student.submitted') }}">
          <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
          <span>Recently Submitted</span>
        </a>
      </li>
      <li>
        <a href="{{ route('student.overdue') }}">
          <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
          <span>Overdue Milestones</span>
        </a>
      </li>
      <li>
        <a href="{{ route('student.upcoming') }}">
          <i class="fa fa-clock-o" aria-hidden="true"></i>
          <span>Upcoming Milestones</span>
        </a>
      </li>
      <li>
        <a href="{{ route('student.amendments') }}">
          <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
          <span>Awaiting Amendments</span>
        </a>
      </li>
    </ul>
  </li>
  @endcan
  @if(
  auth()->user()->can('view', App\Models\Student::class) ||
  auth()->user()->can('view', App\Models\Staff::class) ||
  auth()->user()->can('view', App\Models\Admin::class)
  )
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users" aria-hidden="true"></i>
      <span>Users</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      @can('view', App\Models\Student::class)
      <li>
        <a href="{{ route('student.index') }}">
          <i class="fa fa-graduation-cap" aria-hidden="true"></i>
          <span>Students</span>
        </a>
      </li>
      @endcan
      @can('view', App\Models\Staff::class)
      <li>
        <a href="{{ route('staff.index') }}">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span>Staff</span>
        </a>
      </li>
      @endcan
      @can('view', App\Models\Admin::class)
      <li>
        <a href="{{ route('admin.index') }}">
          <i class="fa fa fa-user-plus" aria-hidden="true"></i>
          <span>Admins</span>
        </a>
      </li>
      @endcan
    </ul>
  </li>
  @endif
  @if(
  auth()->user()->can('manage', App\Models\Programme::class) ||
  auth()->user()->can('manage', App\Models\AbsenceType::class) ||
  auth()->user()->can('manage', App\Models\College::class) ||
  auth()->user()->can('manage', App\Models\EnrolmentStatus::class) ||
  auth()->user()->can('manage', App\Models\FundingType::class) ||
  auth()->user()->can('manage', App\Models\School::class) ||
  auth()->user()->can('manage', App\Models\StudentStatus::class)
  )
  
  <li class="treeview">
    <a href="#">
      <i class="fa fa-cog" aria-hidden="true"></i>
      <span>Settings</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li class="treeview">
        <a href="#">
          <span>Milestone Attributes</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ route('settings.milestone-type.index') }}">Milestone Types</a>
          </li>
          <li>
            <a href="{{ route('settings.timeline.index') }}">Timeline Templates</a>
          </li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <span>Student Attributes</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          @can('manage', App\Models\College::class)
          <li>
            <a href="{{ route('settings.college.index') }}">
              Colleges
            </a>
          </li>
          @endcan
          @can('manage', App\Models\School::class)
          <li>
            <a href="{{ route('settings.school.index') }}">
              Schools
            </a>
          </li>
          @endcan
          @can('manage', App\Models\FundingType::class)
          <li>
            <a href="{{ route('settings.funding-type.index') }}">
              Funding Types
            </a>
          </li>
          @endcan
          @can('manage', App\Models\AbsenceType::class)
          <li>
            <a href="{{ route('settings.absence-type.index') }}">
              Absence Types
            </a>
          </li>
          @endcan
          @can('manage', App\Models\Programme::class)
          <li>
            <a href="{{ route('settings.programme.index') }}">
              Programmes
            </a>
          </li>
          @endcan
          @can('manage', App\Models\StudentStatus::class)
          <li>
            <a href="{{ route('settings.student-status.index') }}">
              Student Statuses
            </a>
          </li>
          @endcan
          @can('manage', App\Models\EnrolmentStatus::class)
          <li>
            <a href="{{ route('settings.enrolment-status.index') }}">
              Enrolment Statuses
            </a>
          </li>
          @endcan
        </ul>
      </li>
    </ul>
  </li>
  @endif
  @can('manage', App\Models\Admin::class)
  <li class="treeview">
    <a href="{{ route('staff.upgrade.index') }}">
      <i class="fa fa-lock" aria-hidden="true"></i>
      <span>Access Control</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="{{ route('staff.upgrade.index') }}">
          <span>Assign Admin Privileges</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.downgrade.index') }}">
          <span>Revoke Admin Privileges</span>
        </a>
      </li>
    </ul>
  </li>
  @endcan
</ul>