@extends('layouts.dashboard')
@section('page_title', 'Admin Overview')
@section('page_description', 'List of all admins')
@section('content')
<div class="content">
  <div class="col-md-12">
            @component('components.datatable')
            @slot('tableId', 'admin-admin-table')
            <td>First Name</td>
            <td>Last Name</td>
            <td>University ID</td>
        @endcomponent
  </div>
</div>
@endsection
