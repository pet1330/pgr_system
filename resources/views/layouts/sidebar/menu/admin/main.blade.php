<ul class="sidebar-menu">
  <li class="header">MAIN MENU</li>
  <li>
    <li>
      <a href="{{ auth()->user()->dashboard_url() }}">
        <i class="fa fa-dashboard" aria-hidden="true"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @include('layouts.sidebar.menu.admin.student')
    @include('layouts.sidebar.menu.admin.staff')
    @include('layouts.sidebar.menu.admin.settings')
    @include('layouts.sidebar.menu.admin.accessControl')
  </li>
</ul>
