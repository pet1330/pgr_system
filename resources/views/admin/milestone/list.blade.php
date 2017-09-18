
@extends('layouts.dashboard')
@section('page_title', $title ?? 'Milestones')
@section('page_description', $subtitle ?? 'Milestones')
@section('content')
<div class="content">
  <div class="col-md-12">
            @component('components.datatable')
            @if( isset($show_submitted) && $show_submitted )
                @slot('tableId', 'admin-submitted-milestones-table')
            @else
                @slot('tableId', 'admin-milestones-table')
            @endif
            <td>Name</td>
            <td>Due Date</td>
            @if( isset($show_submitted) && $show_submitted )
                <td>Submitted Date</td>
            @endif
            <td>School</td>
            <td>First Name</td>
            <td>Last Name</td>
        @endcomponent
  </div>
</div>
@endsection
