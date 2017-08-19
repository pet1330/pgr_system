@extends('layouts.dashboard')
@section('page_title', 'Manage Roles')
@section('page_description', 'List of Roles')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="panel panel-default panel-table">
      <div class="panel-body">
        <table class="table table-striped table-bordered table-list text-center">
          <thead>
            <tr>
              <th>Role Name</th>
              <th>Permissions</th>
              <th colspan="2"><i class="fa fa-gears"></i></th>
            </tr>
          </thead>
          <tbody class="table-striped">
            <div id="confirm">
              @foreach($roles as $role)
              <tr>
                <td>{{ $role->name }}</td>
                <td>
                  @forelse($role->permissions as $permission)
                  <span class="label label-success label-many">{{ $permission->name }}</span>
                  @empty
                  No Assigned Permissions
                  @endforelse
                </td>
                <td>
                  <form action="{{ route('admin.settings.access-control.index', $role->name) }}" method="PATCH">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pencil"></i>
                    </button>
                  </form>
                </td>
                <td>
                  <form
                    method="POST"
                    action="{{ route('admin.settings.access-control.destroy',$role->name) }}"
                    accept-charset="UTF-8"
                    class="delete-form">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button onsubmit="return confirm('Are you sure?');">
                    <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </div>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
