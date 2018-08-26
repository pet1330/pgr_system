<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html> <!--<![endif]-->
  @include('layouts.header')
  <body class="hold-transition skin-blue sidebar-mini">
  @if(config('app.global_message'))
    <div id="global-message" style="z-index: 999999;">
      <b>IMPORTANT MESSAGE:</b> {!! config('app.global_message') !!}
    </div>
  @endif
      <div id="browser-support-check-container">
        <div id="browser-support-check-modal">
            <center>
            <h1>Browser Not Supported!</h1>
            <p>Unfortunally this Internet Explorer version is not supported. To use this service, please consider upgrading to a newer version of Internet Explorer, or changing browser to <a href="https://www.google.com/chrome/">Google Chrome</a> or <a href="https://www.mozilla.org/en-GB/firefox/new/">Firefox</a>.</p>
            <h3>We appologise for this inconvenience</h3>
            </center>
        </div>
    </div>
    <div class="wrapper" id="app">
      @include('layouts.nav.header')
      <aside class="main-sidebar">
        <section class="sidebar">
          <div class="user-panel">
            <div class="pull-left image">
              <img src="{{ auth()->user()->avatar(40) }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>{{ auth()->user()->name }}</p>
              <a href="#">
              <i class="fa fa-circle text-success"></i> {{ auth()->user()->user_type }}</a>
            </div>
          </div>
          @include('layouts.menu')
        </section>
      </aside>
      <div class="content-wrapper">
        <h1 style="padding-top:10px;margin-top: 0; padding-left: 20px">
        @yield('page_title', 'Unknown')
        <small>@yield('page_description', '')</small>
        </h1>
        <section class="content">
          @yield('content')
        </section>
      </div>
      @include('layouts.footer')
      @if( session()->has('flash') )
      <div class="alert alert-flash alert-{{ session('flash')['type'] }}" role="alert">
        {{ session('flash')['message'] }}
      </div>
      @endif
    </div>
    @stack('footer_scripts')
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.3/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.js"></script>
    <script src="{{ url(config('app.url_prefix') . mix('js/app.js')) }}"></script>
    <script defer src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>

  </body>
</html>