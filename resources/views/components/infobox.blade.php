<div class="{{ $size or 'col-md-4 col-sm-6 col-xs-12' }}">
  <div class="info-box">
    <span class="info-box-icon {{ $colour or 'bg-aqua'}}">
      <i class="{{$icon or 'fa fa-gear'}}"></i>
    </span>
    <div class="info-box-content">
      <span class="info-box-text">
        {{ $title or '' }}
      </span>
      <span class="info-box-text">
      {{ $slot }}
      </span>
    </div>
  </div>
</div>
