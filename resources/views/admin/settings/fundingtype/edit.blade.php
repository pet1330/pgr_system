@extends('layouts.dashboard')
@section('page_title', 'Update Absence Type ')
@section('page_description', $funding_type->name)
@section('content')
    <div class="box box box-primary">
      <div class="box-body">
        <label>Update funding type</label>
        <form action="{{ route('settings.funding-type.update', $funding_type->id) }}" method="POST">
        <input type="hidden" name="_method" value="PATCH">
          {{ csrf_field() }}
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-md-12">
            <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name') ?? $funding_type->name }}">
            @if ($errors->has('name'))
            <span class="help-block">
              <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Update Absence Type</button>
        </form>
      </div>
    </div>
</form>
{{-- </section> --}}
{{-- </div> --}}
@endsection