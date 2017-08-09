@extends('layouts.dashboard')
@section('page_title', 'example of page title')
@section('page_description', '')
@section('content')

    {{-- Main content --}}
    <section class="content">
      <div class="row">
        @component('components.infobox')
          @slot('title', 'Number of students')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Student::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of staff')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Staff::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of Admins')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Admin::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of programmes')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Programme::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of Study Modes')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\ModeOfStudy::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of funding types')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\FundingType::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of schools')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\School::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of colleges')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\College::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of Student Records')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\StudentRecord::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of Milestone Types')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\MilestoneType::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number of Milestones')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\Milestone::count() }}
        @endcomponent

        @component('components.infobox')
          @slot('title', 'Number Milestone templates')
          @slot('icon', 'fa fa-gear')
          {{ App\Models\MilestoneTemplate::count() }}
        @endcomponent
      </div>
    </section>
@endsection
