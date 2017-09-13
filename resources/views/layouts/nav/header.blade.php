<header class="main-header">
  <a href="{{ url('/') }}" class="logo">
    <span class="logo-mini"><b>PGR</b></span>
    <span class="logo-lg"><b>PGR</b> System</span>
  </a>
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        @if(auth()->user()->isAdmin())  {{-- CHANGE TO @CAN('See Notifications') --}}
        @include('layouts.nav.notification')
        @endif
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{ auth()->user()->avatar(80)  }}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{auth()->user()->name}}</span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <img src="{{ auth()->user()->avatar(200)  }}" class="img-circle" alt="User Image">
              <p>
                {{ auth()->user()->school->name ?? "hello" }}
                {{-- <small>Since 0000</small> --}}
              </p>
            </li>
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ auth()->user()->dashboard_url() }}" class="btn btn-default btn-flat">
                  Profile
                </a>
              </div>
              <div class="pull-right">
                <a href="{{ url('logout') }}" class="btn btn-default btn-flat">Sign out</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>