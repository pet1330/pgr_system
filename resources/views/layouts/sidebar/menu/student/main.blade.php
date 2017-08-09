<ul class="sidebar-menu">
  <li class="header">MAIN MENU</li>
  <li>
    <li>
      <a href="{{ url('/') }}">
        <i class="fa fa-dashboard" aria-hidden="true"></i>
        <span>Dashboard</span>
      </a>
    </li>
    @include('layouts.sidebar.menu.student.student')
  </li>
</ul>