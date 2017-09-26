<li class="treeview">
  <a href="#">
    <span>Student Attributes</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    @can('update', App\Models\College::class)
    <li>
      <a href="{{ route('admin.settings.college.index') }}">
        Colleges
      </a>
    </li>
    @endcan
    @can('update', App\Models\School::class)
    <li>
      <a href="{{ route('admin.settings.school.index') }}">
        Schools
      </a>
    </li>
    @endcan
    @can('update', App\Models\FundingType::class)
    <li>
      <a href="{{ route('admin.settings.funding-type.index') }}">
        Funding Types
      </a>
    </li>
    @endcan
    @can('update', App\Models\AbsenceType::class)
    <li>
      <a href="{{ route('admin.settings.absence-type.index') }}">
        Absence Types
      </a>
    </li>
    @endcan
    @can('update', App\Models\Programme::class)
    <li>
      <a href="{{ route('admin.settings.programme.index') }}">
        Programmes
      </a>
    </li>
    @endcan
    @can('update', App\Models\StudentStatus::class)
    <li>
      <a href="{{ route('admin.settings.student-status.index') }}">
        Student Statuses
      </a>
    </li>
    @endcan
    @can('update', App\Models\EnrolmentStatus::class)
    <li>
      <a href="{{ route('admin.settings.enrolment-status.index') }}">
        Enrolment Statuses
      </a>
    </li>
    @endcan
  </ul>
</li>