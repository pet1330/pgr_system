@extends('layouts.dashboard')
@section('page_title', 'Edit Student Record')
@section('page_description', '')
@section('content')
<div class="content">
  <div class="col-md-12">
    <div class="box box box-primary">
      <div class="box-body">
        <label>Edit Student Record</label>
        <form action="{{ route('admin.student.record.update',
          [$student->university_id, $record->slug()]) }}" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PATCH">
          {{-- <input type="hidden" name="university_id" value="{{ $student->university_id }}"> --}}
          <div class="row">
            <div class="form-group{{ $errors->has('funding_type_id') ? ' has-error' : '' }} col-md-6">
              <label for="funding_type_id">Funding Type</label>
              <select class="form-control" name="funding_type_id">
                <option value="">--- Select ---</option>
                @foreach($funding_types as $t)
                <option value="{{ $t->id }}"
                  @if($errors->any())
                  {{ (collect(old('funding_type_id'))->contains($t->id)) ? 'selected':'' }}/>
                  @else
                  {{ ($record->fundingType->id == $t->id) ? 'selected':'' }}/>
                  @endif
                  {{ $t->name }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('funding_type_id'))
              <span class="help-block">
                <strong>{{ $errors->first('funding_type_id') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('school_id') ? ' has-error' : '' }} col-md-6">
              <label for="school_id">School</label>
              <select class="form-control" name="school_id">
                <option value="">--- Select ---</option>
                @foreach($schools as $s)
                <option value="{{ $s->id }}"
                  @if($errors->any())
                  {{ (collect(old('school_id'))->contains($s->id)) ? 'selected':'' }}  />
                  @else
                  {{ ($record->school->id == $s->id) ? 'selected':'' }} />
                  @endif
                  {{ $s->name }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('school_id'))
              <span class="help-block">
                <strong>{{ $errors->first('school_id') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="form-group{{ $errors->has('enrolment_status_id') ? ' has-error' : '' }} col-md-6">
              <label for="enrolment_status_id">Enrolment Status</label>
              <select class="form-control" name="enrolment_status_id">
                <option value="">--- Select ---</option>
                @foreach($enrolment_statuses as $es)
                <option value="{{ $es->id }}"
                  @if($errors->any())
                  {{ (collect(old('enrolment_status_id'))->contains($es->id)) ? 'selected':'' }}  />
                  @else
                  {{ ($record->enrolmentStatus->id == $es->id) ? 'selected':'' }} />
                  @endif
                  {{ $es->status }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('enrolment_status_id'))
              <span class="help-block">
                <strong>{{ $errors->first('enrolment_status_id') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('student_status_id') ? ' has-error' : '' }} col-md-6">
              <label for="student_status_id">Student Status</label>
              <select class="form-control" name="student_status_id">
                <option value="">--- Select ---</option>
                @foreach($student_statuses as $t)
                <option value="{{ $t->id }}"
                  @if($errors->any())
                  {{ (collect(old('student_status_id'))->contains($t->id)) ? 'selected':'' }}  />
                  @else
                  {{ ($record->studentStatus->id == $t->id) ? 'selected':'' }} />
                  @endif
                  {{ $t->status }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('student_status_id'))
              <span class="help-block">
                <strong>{{ $errors->first('student_status_id') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="form-group{{ $errors->has('programme_id') ? ' has-error' : '' }} col-md-6">
              <label for="programme_id">Programme</label>
              <select class="form-control" name="programme_id">
                <option value="">--- Select ---</option>
                @foreach($programmes as $p)
                <option value="{{ $p->id }}"
                  @if($errors->any())
                  {{ (collect(old('programme_id'))->contains($p->id)) ? 'selected':'' }}  />
                  @else
                  {{ ($record->programme->id == $p->id) ? 'selected':'' }} />
                  @endif
                  {{ $p->name }}
                </option>
                @endforeach
              </select>
              @if ($errors->has('programme_id'))
              <span class="help-block">
                <strong>{{ $errors->first('programme_id') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="form-group{{ $errors->has('enrolment_date') ? ' has-error' : '' }} col-md-6">
              <label for="enrolment_date">Enrolment Date</label>
              <input type="date"
              class="form-control"
              placeholder="Name"
              name="enrolment_date" value="{{ old('enrolment_date') ?? $record->enrolment_date->format('Y-m-d') }}">
              @if ($errors->has('enrolment_date'))
              <span class="help-block">
                <strong>{{ $errors->first('enrolment_date') }}</strong>
              </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('tierFour') ? ' has-error' : '' }} col-md-6">
              <label class="radio control-label">TierFour</label>
              <label class="radio-inline">
                <input type="radio" name="tierFour" value="1"
                @if($errors->any())
                {{ old('tierFour') === 1 ? 'checked="checked"' : '' }}>
                @else
                {{ $record->tierFour === 1 ? 'checked="checked"' : '' }}>
                @endif
                Yes
              </label>
              <label class="radio-inline">
                <input type="radio" name="tierFour" value="0"
                @if($errors->any())
                {{ old('tierFour') === 0 ? 'checked="checked"' : '' }}>
                @else
                {{ $record->tierFour === 0 ? 'checked="checked"' : '' }}>
                @endif
                No
              </label>
              @if ($errors->has('tierFour'))
              <span class="help-block">
                <strong>{{ $errors->first('tierFour') }}</strong>
              </span>
              @endif
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Update Student Record</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection