<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div class="user-view">
            <a href="{{ Auth::check() ? route('dashboard.runs.index') : route('home') }}" class="brand-logo center"><h4>Risky Picker</h4></a>
        </div>
    </li>

    <li><a class="subheader">Dashboard</a></li>
    <li class="{{ Route::is('dashboard.runs.*') ? 'active' : '' }}"><a href="{{ route('dashboard.runs.index') }}">Runs</a></li>
    <li class="{{ Route::is('dashboard.profile.*') ? 'active' : '' }}"><a href="{{ route('dashboard.profile.show') }}">Profile</a></li>
    <li class="{{ Route::is('dashboard.coffee.*') ? 'active' : '' }}"><a href="{{ route('dashboard.coffee.index') }}">Coffees</a></li>
    <li class="{{ Route::is('dashboard.cups.*') ? 'active' : '' }}"><a href="{{ route('dashboard.cups.index') }}">Cups</a></li>

    @if (Auth::user()->isAdmin())
    <li><a class="subheader">Admin</a></li>
    <li class="{{ Route::is('users.*') ? 'active' : '' }}"><a href="{{ route('users.index') }}">Users</a></li>
    <li class="{{ Route::is('coffees.*') ? 'active' : '' }}"><a href="{{ route('coffees.index') }}">Coffees</a></li>
    <li class="{{ Route::is('schedules.*') ? 'active' : '' }}"><a href="{{ route('schedules.index') }}">Schedules</a></li>
    @endif

    @auth
    <li><a href="{{ route('logout') }}" class="waves-effect waves-light btn" onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Logout
    </a></li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth

</ul>


