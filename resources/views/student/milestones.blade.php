@extends('layouts.dashboard')
@section('page_title', 'Timeline')
@section('page_description', 'Milestones through '. $student->first_name .'\'s study')
@section('content')
<div class="panel-body">
    <a  href="{{ route('student.show', $student->university_id) }}">
        <span class="btn btn-default">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> Profile</span>
    </a>
    @can('createMilestone')
    <a  href="{{ route('student.record.milestone.create', [$student->university_id, $record->slug()]) }}">
        <span class="btn btn-default pull-right">
            Create New Milestone
        </span>
    </a>
    @endcan
</div>
@if($milestones->isNotEmpty())
<div class="col-md-12">
    <h2>Milestones</h2>

    @if($overdue->isNotEmpty())
    <div class="panel panel-danger" id="overdue">
        <div class="panel-heading">
            <h3 class="panel-title">Overdue</h3>
        </div>
        <div class="panel-body">
            <ul>
                @foreach($overdue->sortBy('due_date') as $m)
                <a href="{{ route('student.record.milestone.show',
                    [$student->university_id, $record->slug(), $m->slug()]) }}">
                    <li class="col-md-6 list-unstyled"><b>
                        <span class="fa-stack fa-md" style="margin-right: 20px;">
                            <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                            <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                        </span>
                    {{ $m->name }}</li></a>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if($awaiting->isNotEmpty())
        <div class="panel panel-warning" id="amendments">
            <div class="panel-heading">
                <h3 class="panel-title">Awaiting Amendments</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($awaiting as $m)
                    <a href="{{ route('student.record.milestone.show',
                        [$student->university_id, $record->slug(), $m->slug()]) }}">
                        <li class="col-md-6 list-unstyled"><b>
                            <span class="fa-stack fa-md" style="margin-right: 20px;">
                                <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                            </span>
                        {{ $m->name }}</li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

        @if($upcoming->isNotEmpty())
        <div class="panel panel-warning" id="upcoming">
            <div class="panel-heading">
                <h3 class="panel-title">Upcoming</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($upcoming as $m)
                    <a href="{{ route('student.record.milestone.show',
                        [$student->university_id, $record->slug(), $m->slug()]) }}">
                        <li class="col-md-6 list-unstyled"><b>
                            <span class="fa-stack fa-md" style="margin-right: 20px;">
                                <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                            </span>
                        {{ $m->name }}</li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if($recently_submitted->isNotEmpty())
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Recently Submitted</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($recently_submitted as $m)
                        <a href="{{ route('student.record.milestone.show',
                            [$student->university_id, $record->slug(), $m->slug()]) }}">
                            <li class="col-md-6 list-unstyled"><b>
                                <span class="fa-stack fa-md" style="margin-right: 20px;">
                                    <i class="fa fa-calendar-o fa-stack-2x"
                                    style="transform: scale(1.5,1);">
                                    </i>
                                    <strong class="fa-stack-1x calendar-text"
                                    style="font-size: 12px;margin-top:2.5px;">
                                    {{ $m->submitted_date->format('d/m') }}
                                    </strong>
                                </span>
                                {{ $m->name }}
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if($submitted->isNotEmpty())
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Submitted</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($submitted as $m)
                        <a href="{{ route('student.record.milestone.show',
                            [$student->university_id, $record->slug(), $m->slug()]) }}">
                            <li class="col-md-6 list-unstyled"><b>
                                <span class="fa-stack fa-md" style="margin-right: 20px;">
                                    <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                    <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->submitted_date->format('d/m') }}</strong>
                                </span>
                            {{ $m->name }}</li></a>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                @if($future->isNotEmpty())
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Future</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            @foreach($future as $m)
                            <a href="{{ route('student.record.milestone.show',
                                [$student->university_id, $record->slug(), $m->slug()]) }}">
                                <li class="col-md-6 list-unstyled"><b>
                                    <span class="fa-stack fa-md" style="margin-right: 20px;">
                                        <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                        <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                                    </span>
                                {{ $m->name }}</li></a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

        @if($approved->isNotEmpty())
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Approved</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($approved as $m)
                    <a href="{{ route('student.record.milestone.show',
                        [$student->university_id, $record->slug(), $m->slug()]) }}">
                        <li class="col-md-6 list-unstyled"><b>
                            <span class="fa-stack fa-md" style="margin-right: 20px;">
                                <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                            </span>
                        {{ $m->name }}</li></a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif


                </div>
                @endif
                <div class="col-md-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            {{ $record->start->format('d M Y') }} to {{ $record->end->format('d M Y') }}
                        </div>
                        <div class="panel-body" style="padding: 0px;">
                            <div id="milestone_timeline"></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                var container = document.getElementById('milestone_timeline');
                var items = new vis.DataSet([
                @foreach ($milestones as $m)
                {
                content:'<a href="{{ route('student.record.milestone.show',
                    [$student->university_id, $record->slug(), $m->slug()]) }}" data-toggle="tooltip" data-placement="top" title="{{ $m->name }}"><span class="fa-stack fa-md" style="margin: 0 2px;"><i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i><strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong></span></a>',
                    group: 1,
                    className: 'expected',
                    start: '{{ $m->due_date }}',
                    @if($m->isOverdue())
                    className: 'overdue'
                    @endif
                    },
                    @endforeach

                    @foreach($student->absences as $abs)
                        {content:'{{ $abs->type->name }}',
                        start: '{{ $abs->from }}',
                        end: '{{ $abs->to }}',
                        type: 'background',
                        className: 'absence'},
                    @endforeach

                    ]);
                    var options = {
                    {{--  clickToUse: true, --}}
                    selectable: false,
                    min: new Date('{{ $record->visualTimelineStart()->copy()->subWeeks(4) }}'),  {{-- lower limit of visible range --}}
                    max: new Date('{{ $record->visualTimelineEnd()->copy()->addWeeks(4) }}'),  {{-- upper limit of visible range --}}
                    zoomMin: 1000 * 60 * 60 * 24 * 10,  {{-- one day in milliseconds --}}
                    height:300
                    };
                    {{-- Create a Timeline --}}
                    var timeline = new vis.Timeline(container, items, null, options);
                    </script>
                    {{-- @include('student.example_student') --}}
                    @endsection