<!DOCTYPE html>
<html>
  <body class="hold-transition skin-blue sidebar-mini">
  @if(config('app.global_message'))
    <div id="global-message">
      <b>IMPORTANT MESSAGE:</b> {{ config('app.global_message') }}
    </div>
  @endif
  @include('layouts.header')
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