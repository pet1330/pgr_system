@extends('layouts.dashboard')
@section('page_title', 'Revoke Admin Privileges')
@section('page_description', '')
@section('content')
<div class="content">
    <div class="col-md-12">
        @component('components.datatable')
        @slot('tableId', 'admin-staff-downgrade-table')
        <td>First Name</td>
        <td>Last Name</td>
        <td>University ID</td>
        <td>Remove Admin</td>
        @endcomponent
    </div>
</div>
@endsection
