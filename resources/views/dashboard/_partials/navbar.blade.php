<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
        <a href="{{ url('/') }}" class="nav-link hidden-xs" target="_blank">
            Marinara's Inventory
        </a>
        <a href="{{ url('/') }}" class="nav-link visible-xs" target="_blank">
            MARINARA'S
        </a>
    </form>
    <ul class="navbar-nav navbar-right">
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="/assets/images/avatar/avatar-1.png" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{ \Illuminate\Support\Facades\Session::get('username') }}</div></a>
        <div class="dropdown-menu dropdown-menu-right text-danger">
        {{-- <a href="features-profile.html" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Profile
        </a>
        <a href="features-activities.html" class="dropdown-item has-icon">
            <i class="fas fa-bolt"></i> Activities
        </a>
        <a href="features-settings.html" class="dropdown-item has-icon">
            <i class="fas fa-cog"></i> Settings
        </a> --}}
        <div class="dropdown-divider"></div>
        <a href="{{url('logout')}}" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        </div>
    </li>
    </ul>
</nav>

