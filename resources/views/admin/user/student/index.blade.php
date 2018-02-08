@extends('layouts.dashboard')
@section('page_title', 'Student Overview')
@section('page_description', 'List of all students')
@section('content')
<div class="content">
<div class="panel-body">
    <a  href="{{ route('student.find') }}">
        <span class="btn btn-default pull-right">
        Add A New Student Record</span>
    </a>
</div>
<div class="col-md-12">
    @component('components.datatable')
        @slot('tableId', 'admin-student-table')
        <td>First Name</td>
        <td>Last Name</td>
        <td>University ID</td>
        <td>school</td>
        <td>Tier Four</td>
        <td>Funding Type</td>
        <td>Programme</td>
        <td>Enrolment Status</td>
        <td>Student Status</td>
    @endcomponent
</div>
</div>
@endsection
