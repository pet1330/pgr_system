@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="content">
      <div class="panel panel-primary">
        <div class="panel-heading">
          @if($student->records->count() > 0)
          <h3 class="panel-title">Select Record</h3>
          @endif
        </div>
        <div class="panel-body">
          @forelse($student->records as $record)
          <div class="panel panel-default">
            <div class="panel-heading">
              <a href="{{ route('student.record.show', [$student->university_id, $record->slug()]) }}">
                {{ $record->programme->name }} (Created: {{ $record->created_at->format('d/m/Y') }})
              </a>
            </div>
          </div>
          @empty
          <center><h4>{{ ucfirst($student->first_name) }} does not currently have an active student record</h4></center>
          @endforelse
        </div>
      </div>
      @include('student._previous_records')
      @can('manage', App\Models\Student::class)
        <a href="{{ route('student.record.create', $student->university_id) }}"><button type="submit" class="btn btn-primary">Create New Student Record</button></a>
      @endcan
  </div>
</div>
@endsection