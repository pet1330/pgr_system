@extends('layouts.dashboard')
@section('page_title', 'Student Overview')
@section('page_description', 'List of all students')
@section('content')
<div class="content">
  <div class="col-md-12">
            @component('components.datatable')
            @slot('tableId', 'admin-student-table')
            <td>First Name</td>
            <td>Last Name</td>
            <td>University ID</td>
            <td>Tier Four</td>
            <td>Funding Type</td>
            <td>Enrolment Status</td>
            <td>Programme</td>
            <td>Mode of Study</td>
            <td>Student Status</td>
        @endcomponent
  </div>
</div>
@endsection
