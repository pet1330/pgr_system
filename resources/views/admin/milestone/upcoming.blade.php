@extends('layouts.dashboard')
@section('page_title', 'Upcoming Milestones')
@section('page_description', 'All upcoming milestones')
@section('content')
<div class="content">
  <div class="col-md-12">
            @component('components.datatable')
            @slot('tableId', 'admin-upcoming-milestones-table')
            <td>Name</td>
            <td>Due Date</td>
            <td>First Name</td>
            <td>Last Name</td>
        @endcomponent
  </div>
</div>
@endsection
