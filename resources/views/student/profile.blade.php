
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
                                <td>{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <td>University ID</td>
                                <td>{{ $student->university_id }}</td>
                            </tr>
                            <tr>
                                <td>School</td>
                                <td>{{ $student->school->name }}</td>
                            </tr>
                            <tr>
                                <td>College</td>
                                <td>{{ $student->college->name }}</td>
                            </tr>

                            <tr>
                                <td>Account email</td>
                                <td><a href="mailto:{{ $student->university_email }}"></a> {{ $student->university_email }} </td>
                            </tr>
                            <tr>
                                <td>Start date</td>
                                <td>
                                    {{ 
                                        $student
                                        ->record()
                                        ->enrolment_date
                                        ->format('l jS \\of F Y')
                                    }} <br>
                                    (~{{ 
                                        $student
                                        ->record()
                                        ->enrolment_date
                                        ->diffForHumans()
                                    }})
                                </td>
                            </tr>
                            <tr>
                                <td>Estimated End date</td>
                                <td>
                                    {{ 
                                        $student
                                        ->record()
                                        ->calculateEndDate()
                                        ->format('l jS \\of F Y')
                                    }} <br>
                                    (~{{ 
                                        $student
                                        ->record()
                                        ->calculateEndDate()
                                        ->diffForHumans()
                                    }})
                                </td>
                            </tr>
                            <tr>
                                <td>Tier Four Status</td>
                                <td>{{ $student->tier_four ? 'Yes' : 'No' }}</td>
                            </tr>
                            <tr>
                                <td>Funding type</td>
                                <td>{{ $student->record()->fundingType->name }} funded</td>
                            </tr>
                            <tr>
                                <td>Programme</td>
                                <td>{{ ucfirst($student->record()->programme->name) }}</td>
                            </tr>
                            <tr>
                                <td>Mode of study</td>
                                <td>{{ $student->modeOfStudy->name }}</td>
                            </tr>
                            <tr>
                                <td>Enrolment status</td>
                                <td>
                                    {{ $student->enrolmentStatus->status }}
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
