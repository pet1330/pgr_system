@extends('layouts.dashboard')
@section('page_title', 'example of page title')
@section('page_description', 'example of page descrition')
@section('content')
<div id="app">
    <section class="content">
        @component('components.datatable')
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
    </section>
</div>
@endsection
