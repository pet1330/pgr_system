

@extends('layouts.dashboard')
@section('page_title', 'Overdue Milestones')
@section('page_description', 'All overdue milestones')
@section('content')
<div class="content">
  <div class="col-md-12">
            @component('components.datatable')
            @slot('tableId', 'admin-overdue-milestones-table')
            <td>Name</td>
            <td>Due Date</td>
            <td>First Name</td>
            <td>Last Name</td>
            
        @endcomponent
  </div>
</div>
@endsection
