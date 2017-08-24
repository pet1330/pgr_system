@if(Auth::user()->hasAnyPermission(["assign_permissions_to_user","remove_permissions_from_user","assign_role_to_user","remove_role_from_user","assign_permissions_to_role","remove_permissions_from_role"]))
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users" aria-hidden="true"></i>
      <span>Access Control</span>
      <i class="fa fa-angle-left pull-right"></i>
    </a>
    <ul class="treeview-menu">
      <li>
        <a href="{{ route('admin.settings.access-control.index') }}">Roles</a>
      </li>
      <li>
        <a href="#">User Roles</a>
      </li>
    </ul>
  </li>
@endif