@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="content">
    <div class="col-md-6 col-md-offset-3">
      <div class="box box-primary">
        <div class="box-body text-center">
          <h4>{{ ucfirst($student->first_name) }} does not currently have an active student record</h4>
          @can('manage', App\Models\Student::class)
          <form action="{{ route('student.find') }}" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="university_id" value="{{ $student->university_id }}">
            <button type="submit" class="btn btn-primary">Create one now?</button>
          </form>
          @endcan
        </div>
      </div>
    </div>
      @include('student._previous_records')
  </div>
</div>
@endsection