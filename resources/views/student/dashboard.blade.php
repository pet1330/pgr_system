@extends('layouts.dashboard')
@section('page_title', 'Timeline')
@section('page_description', 'Milestones through '. $student->first_name .'\'s study')
@section('content')

<div class="panel-body">
  <a  href="{{ route('admin.student.milestone.create', $student->id) }}">
    <span class="btn btn-default pull-right">
      Create New Milestone
    </span>
  </a>
</div>
@if($milestones->isNotEmpty())
    <div class="col-md-12">
    <h2>Milestones</h2>
    @if($overdue->isNotEmpty())
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Overdue</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($overdue->sortBy('due_date') as $m)
                    <a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}">
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
    {{-- <div class="box box-primary"> --}}
        
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title">Upcoming</h3>
            </div>
            <div class="panel-body">
                <ul>
                    @foreach($upcoming as $m)
                    <a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}">
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
                    <a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}">
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
                    <a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}">
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
                    <a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}">
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
<div class="col-md-6">
{{-- <h2>Actions</h2>
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Unknown</h3>
        </div>
        <div class="panel-body">
                <form>
        <div class="form-group">
            <label for="milestone">New Milestone</label>
            <input type="text" class="form-control" id="milestone">
        </div>
        <div class="form-group">
            <label for="exampleInputFile">File input</label>
            <input type="file" id="exampleInputFile">
            <p class="help-block">Attach example form here.</p>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox"> Student can create
            </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
        </div>
    </div> --}}
</div>

{{-- ---------------------------------------------------------------------- --}}

<div class="col-md-12 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ $student->record()->start->format('d M Y') }} to {{ $student->record()->end->format('d M Y') }}
        </div>
        <div class="panel-body" style="padding: 0px;">
            <div id="milestone_timeline"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
// DOM element where the Timeline will be attached
var container = document.getElementById('milestone_timeline');

// Create the event items
var items = new vis.DataSet([
    @foreach ($milestones as $m)
    {
        content:'<a href="{{ route('admin.student.milestone.show', [$student->id, $m->id]) }}" data-toggle="tooltip" data-placement="top" title="{{ $m->name }}"><span class="fa-stack fa-md" style="margin: 0 2px;"><i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i><strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong></span></a>',
        group: 1,
        className: 'expected',
        start: '{{ $m->due_date }}',
        @if($m->isOverdue())
        className: 'overdue'
        @endif
    },
    @endforeach
    ]);

// Configuration for the Timeline
var options = {
    // clickToUse: true,
    selectable: false,
    min: new Date('{{ $student->record()->start }}'),  // lower limit of visible range
    max: new Date('{{ $student->record()->end }}'),  // upper limit of visible range
    zoomMin: 1000 * 60 * 60 * 24 * 10  // one day in milliseconds
};

// Create a Timeline
var timeline = new vis.Timeline(container, items, null, options);
</script>
{{-- @include('student.example_student') --}}

@endsection