@extends('layouts.dashboard')
@section('page_title', 'Create a Student Record')
@section('page_description', "")
@section('content')
<div class="row">
    @if($student->records->isNotEmpty())
    <div class="form-group alert alert-danger col-md-8 col-md-offset-2">
        <label>Warning! {{ $student->name }} already has {{ $student->records->count() }} record. Creating a new one, will archive this <a href="{{ $student->dashboard_url() }}">previous record.</label>
    </div>
    @endif
    <div class="col-md-3 col-md-offset-4">
        <div class="thumbnail">
            <img src="{{ $student->avatar(400) }}">
            <div class="caption">
                <h3>{{ $student->name }}</h3>
                <div class="form-group text-center">
                Is this the correct student?
                    <form action="{{ route('student.confirm') }}" method="POST">
                        {{ csrf_field() }}
                    <button class="col-md-4 col-md-offset-1 btn btn-primary" role="button">Yes</button>
                    </form>
                    <p><a href="{{ route('student.find') }}" class="col-md-4 col-md-offset-1 btn btn-default" role="button">No</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
