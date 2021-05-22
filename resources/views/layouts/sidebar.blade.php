<nav class="sidebar-nav">
  <ul id="sidebarnav">
    <li class="nav-devider"></li>
    <li class="nav-small-cap">MENU</li>
    <li class="{{ Request::is('home*') ? 'active' : '' }}">
      <a class="waves-effect waves-dark" href="{{url('/home')}}" aria-expanded="false">
        <i class="fa fa-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>
     <li class="{{ Request::is('request*') ? 'active' : '' }}">
      <a class="waves-effect waves-dark" href="{{url('/request')}}" aria-expanded="false">
        <i class="fa fa-dropbox"></i>
        <span class="hide-menu">Request
        </span>
      </a>
    </li>
    @if(Auth::User()->role == "Admin")
    <li class="{{ Request::is('user*') ? 'active' : '' }}">
      <a class="waves-effect waves-dark" href="{{url('/users')}}" aria-expanded="false">
        <i class="fa fa-users"></i>
        <span class="hide-menu">User
        </span>
      </a>
    </li>
    @endif

    @if(Auth::User()->role == "Admin")
    <li class="{{ Request::is('project*') ? 'active' : '' }}">
      <a class="waves-effect waves-dark" href="{{url('/project')}}" aria-expanded="false">
        <i class="fa fa-cog"></i>
        <span class="hide-menu">Project
        </span>
      </a>
    </li>
    @endif
    
    @if(Auth::User()->role == "Admin")
    <li class="{{ Request::is('tim*') ? 'active' : '' }}">
      <a class="waves-effect waves-dark" href="{{url('/tim')}}" aria-expanded="false">
        <i class="fa fa-user"></i>
        <span class="hide-menu">Tim
        </span>
      </a>
    </li>
    @endif
  </ul>
</nav>
