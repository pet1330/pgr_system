<ul class="sidebar-menu">
    <li>
      <a href="#">
        <i class="fa fa-medkit" aria-hidden="true"></i>
        <span>Absences</span>
      </a>
    </li>
    <li class="treeview">
      <a href="#">
        <i class="fa fa-calendar-o"></i>
        <span>Milestones</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        <li>
          <a href="#">Upcoming</a>
        </li>
        <li>
          <a href="#">Overdue</a>
        </li>
        <li>
          <a href="#">Previous</a>
        </li>
        <li>
          <a hred="#">All Forms</a>
        </li>
      </ul>
    </li>

    <li class="treeview">
      <a href="#">
        <i class="fa fa-users"></i>
        <span>Supervisors</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        @foreach(Auth::user()->supervisors()->orderBy('supervisor_type')->get() as $sup)
          <li>
            <a href="#">{{ $sup->name }}</a>
          </li>
        @endforeach
      </ul>
    </li>
</ul>

