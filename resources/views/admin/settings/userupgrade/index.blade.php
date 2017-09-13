@extends('layouts.dashboard')
@section('page_title', 'Staff Upgrade')
@section('page_description', 'Staff eligible for upgraded')
@section('content')
<div class="content">
    <div class="col-md-12">
        @component('components.datatable')
        @slot('tableId', 'admin-staff-upgrade-table')
        <td>First Name</td>
        <td>Last Name</td>
        <td>University ID</td>
        <td>Make Admin</td>
        @endcomponent
    </div>
</div>
@endsection
