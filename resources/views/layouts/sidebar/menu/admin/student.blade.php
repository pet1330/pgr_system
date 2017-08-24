<li class="treeview">
  <a href="#">
    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
    <span>Student</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{ route('admin.student.index') }}">Overview</a>
    </li>
    <li>
      <a href="{{ route('admin.student.overdue') }}">Overdue Milestones</a>
    </li>
    <li>
      <a href="{{ route('admin.student.upcoming') }}">Upcoming Milestones</a>
    </li>
    <li>
      <a href="{{ route('admin.student.submitted') }}">Submitted Milestones</a>
    </li>
  </ul>
</li>