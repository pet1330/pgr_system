<li class="treeview">
  <a href="#">
    <i class="fa fa-users" aria-hidden="true"></i>
    <span>Access Control</span>
    <i class="fa fa-angle-left pull-right"></i>
  </a>
  <ul class="treeview-menu">
    <li>
      <a href="{{ route('admin.settings.role-permissions.index') }}">Manage Role Permissions</a>
    </li>
    <li>
      <a href="{{ route('admin.settings.user-roles.index') }}">Manage User Roles</a>
    </li>
    <li>
      <a href="{{ route('admin.staff.upgrade.index') }}">Manage User Types</a>
    </li>
  </ul>
</li>