@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="content">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Select Record</h3>
        </div>
        <div class="panel-body">
          @foreach($student->records as $record)
          <div class="panel panel-default">
            <div class="panel-heading">
              <a href="{{ route('student.record.show', [$student->university_id, $record->slug()]) }}">
                {{ $record->programme->name }} (Created: {{ $record->created_at->format('d/m/Y') }})
              </a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @include('student._previous_records')
  </div>
</div>
@endsection