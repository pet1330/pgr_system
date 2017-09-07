@extends('layouts.dashboard')
@section('page_title', $student->name .'\'s Dashboard')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="content">
  @if($student->record() !== null)
    @include('student._with_record_dashboard')
  @else
    @include('student._no_record_dashboard')
  @endif
  </div>
</div>
@endsection