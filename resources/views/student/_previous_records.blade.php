@can('manage', App\Models\Student::class)
@if($student->records()->onlyTrashed()->count() > 0)
<div class="col-md-12">
  <div class="box box box-danger">
    <div class="box-body">
      <div class="panel-heading">
        <h4 class="panel-title">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseone">
          Show Archived Record{{ $student->records()->onlyTrashed()->count() > 1 ? 's' : '' }}
        </a>
        </h4>
      </div>
      <div id="collapseone" class="panel-collapse collapse">
        <div class="panel-body">
          @foreach($student->records()->onlyTrashed()->get() as $record)
          <div class="col-md-12">
            <a href="{{ route('student.record.restore', [$student->university_id, $record->id]) }}">
              <span class="btn btn-success">Restore</span>
            </a>
            {{ $record->programme->name }} (Created: {{ $record->created_at->format('d/m/Y') }})
            <span class="pull-right">Archived: {{ $record->deleted_at->format('d/m/Y') }}</span>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endif
@endcan