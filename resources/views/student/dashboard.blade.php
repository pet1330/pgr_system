@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
    <div class="content">
        <div class="panel-body">
            <a  href="{{ route('admin.student.absence.create', $student->university_id) }}">
                <span class="btn btn-default pull-right">
                    Create New Absence
                </span>
            </a>
        </div>
        @if($overdue->isNotEmpty() or $upcoming->isNotEmpty())
        <div class="col-md-6">
            <h4 class="alert alert-danger">The following milestones require your attention</h4>
            @if($overdue->isNotEmpty())
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Overdue</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($overdue->sortBy('due_date') as $m)
                        <a href="{{ route('admin.student.milestone.show', [$student->record()->id, $m->slug()]) }}">
                            <li class="col-md-12 list-unstyled">
                                <span class="fa-stack fa-md" style="margin-right: 20px;">
                                    <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                    <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                                </span>
                                {{ $m->name }}
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            @if($upcoming->isNotEmpty())
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">Upcoming</h3>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($upcoming as $m)
                        <a href="{{ route('admin.student.milestone.show', [$student->record()->id, $m->slug()]) }}">
                            <li class="col-md-6 list-unstyled">
                                <span class="fa-stack fa-md" style="margin-right: 20px;">
                                    <i class="fa fa-calendar-o fa-stack-2x" style="transform: scale(1.5,1);"></i>
                                    <strong class="fa-stack-1x calendar-text" style="font-size: 12px;margin-top:2.5px;">{{ $m->due_date->format('d/m') }}</strong>
                                </span>
                                {{ $m->name }}
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
            <div class="panel-body">
                <a  href="{{ route('admin.student.milestone.index', $student->university_id) }}">
                    <span class="btn btn-default">
                        View All Milestones
                    </span>
                </a>
            </div>
        </div>
        @else
        You have no upcoming or or overdue milestones! Congrats!
                    <div class="panel-body">
                <a  href="{{ route('admin.student.milestone.index', $student->university_id) }}">
                    <span class="btn btn-default">
                        View All Milestones
                    </span>
                </a>
            </div>
        @endif
    </div>
    @endsection