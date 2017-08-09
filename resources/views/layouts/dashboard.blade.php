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
          @include('layouts.sidebar.menu.' . lcfirst(Auth::user()->user_type) . '.main')
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
      <flash message="{{ session('flash') }}"></flash>
      <bug-report></bug-report>
    </div>
    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script> --}}
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
