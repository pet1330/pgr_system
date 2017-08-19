@extends('layouts.dashboard')
@section('page_title', 'Milestones')
@section('page_description', 'A list of all milestones in the system')
@section('content')
<div class="content">
    <div class="col-md-12">
        <div class="panel panel-default panel-table">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list text-center">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>duration</th>
                            <th>due</th>
                            <th>submission_date</th>
                            <th>approval_required</th>
                            <th>approval_granted</th>
                            <th>approved_on</th>
                            <th>approved_by</th>
                            <th>student_record_id</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody class="table-striped">
                        <div id="confirm">
                            @foreach($milestones as $stone)
                            <tr>
                                <td>{{ $stone->id }}</td>
                                <td>{{ $stone->duration }}</td>
                                <td>{{ $stone->due }}</td>
                                <td>{{ $stone->submission_date }}</td>
                                <td>{{ $stone->approval_required }}</td>
                                @if($stone->approval_required)
                                    <td>{{ $stone->approval_granted }}</td>
                                    <td>{{ $stone->approved_on }}</td>
                                    <td>{{ $stone->approved_by }}</td>
                                @else
                                <td></td>
                                <td></td>
                                <td></td>
                                @endif
                                <td>{{ $stone->student_record_id }}</td>
                                <td>{{ $stone->milestone_type->name }}</td>
                            </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
                {{ $milestones->links() }}
            </div>
        </div>
    </div>
</div>
</div>
@endsection