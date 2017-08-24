@extends('layouts.dashboard')
@section('page_title', $timeline->name)
@section('page_description', "")
@section('content')
<div id="app">
  <section class="content">


{{-- {{ route('admin.student.milestone.edit', [$student->id, $milestone->id]) }} --}}

<div class="panel-body">
  <a  href="{{ route('admin.settings.timeline.milestone.create', $timeline->id) }}">
    <span class="btn btn-default pull-right">
      Add a Milestone</span>
  </a>
</div>



    {{ dump( $timeline->getAttributes() ) }}


    {{ dump( $timeline->milestone_templates ) }}

  </section>
</div>
@endsection
 