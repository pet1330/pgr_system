
@extends('layouts.dashboard')
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
                                <td>{{ Auth::user()->name }}</td>
                            </tr>
                            <tr>
                                <td>University ID</td>
                                <td>{{ Auth::user()->university_id }}</td>
                            </tr>
                            <tr>
                                <td>School</td>
                                <td>{{ Auth::user()->school->name ?? 'unknown' }}</td>
                            </tr>
                            <tr>
                                <td>College</td>
                                <td>{{ Auth::user()->college->name ?? 'unknown' }}</td>
                            </tr>

                            <tr>
                                <td>Account email</td>
                                <td><a href="mailto:{{ Auth::user()->university_email }}"></a> {{ Auth::user()->university_email }} </td>
                            </tr>
                            <tr>
                                <td>Start date</td>
                                <td>
                                    {{ 
                                        Auth::user()
                                        ->record()
                                        ->enrolment_date
                                        ->format('l jS \\of F Y') ?? 'unknown'
                                    }} <br>
                                    (~{{ 
                                        Auth::user()
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
                                        Auth::user()
                                        ->record()
                                        ->calculateEndDate()
                                        ->format('l jS \\of F Y') ?? 'unknown'
                                    }} <br>
                                    (~{{ 
                                        Auth::user()
                                        ->record()
                                        ->calculateEndDate()
                                        ->diffForHumans() ?? 'unknown'
                                    }})
                                </td>
                            </tr>
                            <tr>
                                <td>Tier Four Status</td>
                                <td>{{ (Auth::user()->tier_four ? 'Yes' : 'No') ?? 'unknown'}}</td>
                            </tr>
                            <tr>
                                <td>Funding type</td>
                                <td>{{ Auth::user()->record()->fundingType->name ?? 'unknown' }} funded</td>
                            </tr>
                            <tr>
                                <td>Programme</td>
                                <td>{{ ucfirst(Auth::user()->record()->programme->name) ?? 'unknown' }}</td>
                            </tr>
                            <tr>
                                <td>Mode of study</td>
                                <td>{{ Auth::user()->modeOfStudy->name ?? 'unknown'}}</td>
                            </tr>
                            <tr>
                                <td>Enrolment status</td>
                                <td>
                                    {{ Auth::user()->enrolmentStatus->status ?? 'unknown' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
