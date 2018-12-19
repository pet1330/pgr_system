@extends('layouts.dashboard')
@section('page_title', 'Update School')
@section('page_description', $school->name)
@section('content')
<div class="box box box-primary">
  <div class="box-body">
    <form action="{{ route('settings.school.update', $school->slug()) }}" method="POST">
      <input type="hidden" name="_method" value="PATCH">
      {{ csrf_field() }}
      <div class="row">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-4">
          <label for="name">School Name</label>
          <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $school->name }}">
          @if ($errors->has('name'))
          <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
          </span>
          @endif
        </div>
        <div class="form-group{{ $errors->has('college_id') ? ' has-error' : '' }} col-md-4">
          <label for="college_id">College</label>
          <select class="form-control" name="college_id">
            <option value="">--- Select ---</option>
            @foreach($colleges as $c)
            <option value="{{ $c->id }}"
              @if($errors->any())
              {{ (collect(old('college_id'))->contains($c->id)) ? 'selected':'' }}  />
              @else
              {{ ($school->college->id == $c->id) ? 'selected':'' }} />
              @endif
              {{ $c->name }}
            </option>
            @endforeach
          </select>
          @if ($errors->has('college_id'))
          <span class="help-block">
            <strong>{{ $errors->first('college_id') }}</strong>
          </span>
          @endif
        </div>




        <div class="form-group{{ $errors->has('notifications_address') ? ' has-error' : '' }} col-md-4">
          <label for="notifications_address">Notifications Address</label>
          <input type="text" class="form-control" placeholder="Email Address" name="notifications_address" value="{{ old('notifications_address') ?? $school->notifications_address }}">
          @if ($errors->has('notifications_address'))
          <span class="help-block">
            <strong>{{ $errors->first('notifications_address') }}</strong>
          </span>
          @endif
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Update School</button>
    </form>
  </div>
</div>
@endsection