@extends('layouts.dashboard')
@section('page_title', 'Timeline')
@section('page_description', 'Milestones through your study')
@section('content')

{{-- @foreach ( $student->record()->timeline()->orderBy('due')->get() as $milestone )
<div class="panel panel-default event">
  <div class="panel-body">
    <div class="info col-xs-10 col-sm-10">
        {{ $milestone->name }}
    </div>
  </div>
</div>
@endforeach --}}
<table class="table table-striped table-bordered table-list text-center">
    <thead>
        <tr>
            <th>name</th>
            <th>start</th>
            <th>due</th>
            <th>submission_date</th>
            <th>approval_required</th>
            <th>approved</th>
            <th>approved_on</th>
            <th>approved_by</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ( $student->record()->timeline()->orderBy('due')->get() as $milestone )
            <tr>
                <td>{{ $milestone->name }}</td>
            <td>{{ $student->record()->start->subMonths($milestone->duration)->format('d/m/y') }}</td>
                <td>{{ $student->record()->start->addMonths($milestone->due)->format('d/m/y') }}</td>
                <td>{{ $milestone->submission_date }}</td>
                <td>{{ $milestone->approval_granted }}</td>
                <td>{{ $milestone->approval_required }}</td>
                <td>{{ $milestone->approved_on }}</td>
                <td>{{ $milestone->approved_by }}</td>               
                </tr>
        @endforeach
    </tbody>
</table>
    

<hr style="width: 100%; color: black; height: 1px; background-color:black;" />

{{-- @include('student.example_student') --}}

@endsection