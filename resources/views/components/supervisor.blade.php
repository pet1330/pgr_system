@if($supervisor !== null)
<h3 style="margin-top: 2px;">{{ $title or '' }}</h3>
<div class="box box-primary">
  <div class="panel-body text-center">
    @can('update', $student)
    @can('create', App\Models\Staff::class)
    <form method="POST" action="{{ route('admin.student.record.supervisor.destroy',
      [$student->university_id, $record->slug(), $supervisor->university_id]) }}"
      accept-charset="UTF-8" class="delete-form" onsubmit="return confirm('Are you sure?');">
        <input type="hidden" name="_method" value="DELETE">
        {{ csrf_field() }}
        <button class="btn btn-link pull-right">
          <span aria-hidden="true" class="badge alert-danger">
            <i class="fa fa-trash"></i>
          </span>
        </button>
    </form>
    @endcan
    @endcan
    <img src="{{ $supervisor->avatar(200) }}" class="img-circle col-md-4" style="max-height: 90px; width: auto;">
    <div class="caption col-md-8">
      <h3>{{ $supervisor->name }}</h3>
      <a href="mailto:{{ $supervisor->university_email }}">
        {{ $supervisor->university_email }}
      </a>
    </div>
  </div>
</div>
@endif