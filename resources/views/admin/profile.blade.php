No Longer used: see views: admin.profile 

{{-- @extends('layouts.dashboard')
@section('page_title', 'Your Profile')
@section('page_description', '')
@section('content')
<div id="app">
  <div class="col-md-12">
    <div class="box box-info">
      <div class="box-body">
        <div class="table-responsive">
          <table class="table user-profile">
            <tbody>
              <tr>
                <td>Name</td>
                <td>{{ auth()->user()->name }}</td>
              </tr>
              <tr>
                <td>University ID</td>
                <td>{{ auth()->user()->university_id }}</td>
              </tr>
              <tr>
                <td>School</td>
                <td>{{ auth()->user()->school->name ?? 'unknown' }}</td>
              </tr>
              <tr>
                <td>College</td>
                <td>{{ auth()->user()->college->name ?? 'unknown' }}</td>
              </tr>
              <tr>
                <td>Account email</td>
                <td><a href="mailto:{{ auth()->user()->university_email }}"></a> {{ auth()->user()->university_email }} </td>
              </tr>
              <tr>
                <td>Start date</td>
                <td>
                  {{
                  auth()->user()
                  ->record()
                  ->enrolment_date
                  ->format('l jS \\of F Y') ?? 'unknown'
                  }} <br>
                  (~{{
                  auth()->user()
                  ->record()
                  ->enrolment_date
                  ->diffForHumans() ?? 'unknown'
                  }})
                </td>
              </tr>
              <tr>
                <td>Estimated End date</td>
                <td>
                  {{
                  auth()->user()
                  ->record()
                  ->calculateEndDate()
                  ->format('l jS \\of F Y') ?? 'unknown'
                  }} <br>
                  (~{{
                  auth()->user()
                  ->record()
                  ->calculateEndDate()
                  ->diffForHumans() ?? 'unknown'
                  }})
                </td>
              </tr>
              <tr>
                <td>Tier Four Status</td>
                <td>{{ (auth()->user()->tier_four ? 'Yes' : 'No') ?? 'unknown'}}</td>
              </tr>
              <tr>
                <td>Funding type</td>
                <td>{{ auth()->user()->record()->fundingType->name ?? 'unknown' }} funded</td>
              </tr>
              <tr>
                <td>Programme</td>
                <td>{{ ucfirst(auth()->user()->record()->programme->name) ?? 'unknown' }}</td>
              </tr>
              <tr>
                <td>Enrolment status</td>
                <td>
                  {{ auth()->user()->enrolmentStatus->status ?? 'unknown' }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}