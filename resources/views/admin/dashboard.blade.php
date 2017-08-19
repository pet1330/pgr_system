@extends('layouts.dashboard')
@section('page_title', $admin->name)
@section('page_description', 'Dashboard')
@section('content')

    {{-- Main content --}}
    <section class="content">
      <div class="row">

        @component('components.infobox')
          @slot('title', 'students')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Student::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'staff')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Staff::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Admins')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Admin::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'programmes')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Programme::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Study Modes')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\ModeOfStudy::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'funding types')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\FundingType::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'schools')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\School::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'colleges')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\College::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Student Records')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\StudentRecord::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Milestone Types')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\MilestoneType::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Milestones')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Milestone::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Milestone Templates')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\MilestoneTemplate::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Timeline Templates')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\TimelineTemplate::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'This Admin')
          @slot('icon', 'fa fa-gear')
          DB ID: {{ $admin->id ?? "Unknown Admin" }} <br>
          UNI ID: {{ $admin->university_id ?? "Unknown Admin" }}
        @endcomponent

      </div>
    </section>
@endsection
