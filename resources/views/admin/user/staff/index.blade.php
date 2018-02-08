@extends('layouts.dashboard')
@section('page_title', 'Staff Overview')
@section('page_description', 'List of all staff')
@section('content')
<div class="content">
    <div class="panel-body">
        <a  href="{{ route('staff.find') }}">
            <span class="btn btn-default pull-right">
            Add A New Staff Member</span>
        </a>
    </div>
    <div class="col-md-12">
        @component('components.datatable')
        @slot('tableId', 'admin-staff-table')
        <td>First Name</td>
        <td>Last Name</td>
        <td>University ID</td>
        @endcomponent
    </div>
</div>
@endsection