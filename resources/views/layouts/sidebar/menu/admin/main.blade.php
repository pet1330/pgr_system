<ul class="sidebar-menu">
  <li class="header">MAIN MENU</li>
  <li>
    <li>
      <a href="{{ auth()->user()->dashboard_url() }}">
        <i class="fa fa-dashboard" aria-hidden="true"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @can('view', App\Models\Student::class)
      @include('layouts.sidebar.menu.admin.student')
    @endcan
    @can('view', App\Models\Staff::class)
      @include('layouts.sidebar.menu.admin.staff')
    @endcan

    @if(
      auth()->user()->can('update', App\Models\Programme::class) ||
      auth()->user()->can('update', App\Models\AbsenceType::class) ||
      auth()->user()->can('update', App\Models\College::class) ||
      auth()->user()->can('update', App\Models\EnrolmentStatus::class) ||
      auth()->user()->can('update', App\Models\FundingType::class) ||
      auth()->user()->can('update', App\Models\School::class) ||
      auth()->user()->can('update', App\Models\StudentStatus::class)
      )
      @include('layouts.sidebar.menu.admin.settings')
    @endif
    @include('layouts.sidebar.menu.admin.accessControl')
  </li>
</ul>
