@extends('layouts.dashboard')
@section('page_title', 'Create a Supervisor')
@section('page_description', "")
@section('content')
<div class="col-md-6 col-md-offset-3 text-center">
    <div class="box box box-primary">
        <div class="box-body">
            This member of staff does not appear to be in our system yet.<br><br>
            <label>Please confirm the university ID</label>
            <form action="{{ route('supervisor.confirm_id', [$student->university_id, $record->slug()]) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('staff_id') ? ' has-error' : '' }}">
                    <input type="text" class="form-control" placeholder="University ID" name="staff_id" value="{{ old('staff_id') }}">
                    @if ($errors->has('staff_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('staff_id') }}</strong>
                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Confirm Student ID</button>
            </form>
        </div>
    </div>
</div>
@endsection
