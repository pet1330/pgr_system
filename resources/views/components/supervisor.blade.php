@if($supervisor !== null)
    <h3 style="margin-top: 2px;">{{ $title or '' }}</h3>
    <div class="box box-primary">
      <div class="panel-body text-center">
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
