{{-- Main Header --}}
  <header class="main-header">

    {{-- Logo --}}
    <a href="{{ url('/') }}" class="logo">
      {{-- mini logo for sidebar mini 50x50 pixels --}}
      <span class="logo-mini"><b>PGR</b></span>
      {{-- logo for regular state and mobile devices --}}
      <span class="logo-lg"><b>PGR</b> System</span>
    </a>

    {{-- Header Navbar --}}
    <nav class="navbar navbar-static-top" role="navigation">
       {{-- Sidebar toggle button --}}
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      {{-- Navbar Right Menu --}}
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
           {{-- Messages: style can be found in dropdown.less --}}
          
           @if(Auth::user()->user_type === 'Admin')  {{-- CHANGE TO @CAN('See Notifications') --}}
            @include('layouts.nav.notification')
           @endif

          {{-- User Account Menu --}}
          <li class="dropdown user user-menu">
            {{-- Menu Toggle Button --}}
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               {{-- The user image in the navbar --}}
              <img src="{{ Auth::user()->avatar(80)  }}" class="user-image" alt="User Image">
              {{-- hidden-xs hides the username on small devices so only the image appears. --}}
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              {{-- The user image in the menu --}}
              <li class="user-header">
                <img src="{{ Auth::user()->avatar(200)  }}" class="img-circle" alt="User Image">

                <p>
                  {{ Auth::user()->school->name ?? "hello" }}
                  {{-- <small>Since 0000</small> --}}
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ Auth::user()->dashboard_url() }}" class="btn btn-default btn-flat">
                    Profile
                  </a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          {{-- Control Sidebar Toggle Button --}}
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>