<ul class="sidebar-menu">
  <li class="header">HEADER</li>
  {{-- Optionally, you can add icons to the links --}}
  <li class="active">
    <li>
      <a href="/break">
        <i class="fa fa-link"></i>
        <span>Staff</span>
      </a>
    </li>
    <li>
      <a href="/break">
        <i class="fa fa-link"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-link"></i>
        <span>Student</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="#">Overview</a>
        </li>
        <li>
          <a href="#">Overdue</a>
        </li>
        <li>
          <a href="#">Upcoming</a>
        </li>
        <li>
          <a href="{{route('admin.settings.student.index')}}">Reports</a>
        </li>
        <li>
          <a href="#">Settings</a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-link"></i>
        <span>Staff</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="#">Overview</a>
        </li>
        <li>
          <a href="#">Overdue</a>
        </li>
        <li>
          <a href="#">Upcoming</a>
        </li>
        <li>
          <a href="{{route('admin.settings.student.index')}}">Reports</a>
        </li>
        <li>
          <a href="#">Settings</a>
        </li>
      </ul>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-link"></i>
        <span>Settings</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="#">student settings</a>
        </li>
        <li>
          <a href="#">staff settings</a>
        </li>
        <li>
          <a href="#">sidewide settings</a>
        </li>
      </ul>
    </li>
  </li>
</ul>