<!DOCTYPE html>
<html>
  @include('layouts.header')
  {{--
  SKINS: skin-blue, skin-black, skin-purple, skin-yellow, skin-red, skin-green
  LAYOUT OPTIONS fixed, layout-boxed, layout-top-nav, sidebar-collapse, sidebar-mini
  --}}
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
      @include('layouts.nav.header')
      <aside class="main-sidebar">
        {{-- sidebar: style can be found in sidebar.scss --}}
        <section class="sidebar">
          @include('layouts.sidebar.user')
          @include('layouts.sidebar.search')
          @include('layouts.sidebar.menu.' . lcfirst(auth()->user()->user_type) . '.main')
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
      @include('layouts.sidebar.right_sidebar')
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
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
    $(function() {
    $('#datepicker').datepicker({ changeMonth: true, changeYear: true, inline: true,
    dateFormat: "yy-mm-dd", altField: "#d", altFormat: "yy-mm-dd" });
    $('#enrolment_date').change(function(){ $('#datepicker').datepicker('setDate', $(this).val()); });
    $('#datepicker').change(function(){ $('#enrolment_date').attr('value',$(this).val()); });
    $('#datepicker').datepicker('setDate', $('#enrolment_date').val());
    });
    </script>
  </body>
</html>