@extends('layouts.dashboard')
@section('page_title', 'Find a Staff Member')
@section('page_description', "")
@section('content')
<div class="col-md-6 col-md-offset-3 text-center">
    <div class="box box box-primary">
        <div class="box-body">
            This staff member does not appear to be in our system yet.<br><br>
            <label>Please confirm the staff ID</label>
            <form action="{{ route('staff.confirm_id') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('university_id') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="University ID" name="university_id" value="{{ old('university_id') }}">
                    @if ($errors->has('university_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('university_id') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Confirm Staff ID</button>
            </form>
        </div>
    </div>
</div>
@endsection
