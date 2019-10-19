<ul id="slide-out" class="sidenav sidenav-fixed">
    <li>
        <div class="user-view">
            <a href="{{ Auth::check() ? route('dashboard.runs.index') : route('home') }}" class="brand-logo center"><h4>Risky Picker</h4></a>
        </div>
    </li>

    <li><a class="subheader">Dashboard</a></li>
    <li class="{{ Route::is('dashboard.runs.*') ? 'active' : '' }}"><a href="{{ route('dashboard.runs.index') }}">Coffee Runs</a></li>
    <li class="{{ Route::is('dashboard.profile.*') ? 'active' : '' }}"><a href="{{ route('dashboard.profile.show') }}">My Profile</a></li>
    <li class="{{ Route::is('dashboard.coffee.*') ? 'active' : '' }}"><a href="{{ route('dashboard.coffee.index') }}">My Coffees</a></li>
    <li class="{{ Route::is('dashboard.cups.*') ? 'active' : '' }}"><a href="{{ route('dashboard.cups.index') }}">My Cups</a></li>

    <li><div class="divider"></div></li>

    @if (Auth::user()->isAdmin())
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
                <li class="{{ Route::is('admin.*') ? 'active' : '' }}">
                    <a class="collapsible-header">Settings<i class="material-icons">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li class="{{ Route::is('admin.users.*') ? 'active' : '' }}"><a href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="{{ Route::is('admin.coffees.*') ? 'active' : '' }}"><a href="{{ route('admin.coffees.index') }}">Coffees</a></li>
                            <li class="{{ Route::is('admin.schedules.*') ? 'active' : '' }}"><a href="{{ route('admin.schedules.index') }}">Schedules</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
    @endif

    @auth
        <li><a href="{{ route('logout') }}" class="waves-effect waves-light btn" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="material-icons left">power_settings_new</i>Logout
        </a></li>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

</ul>


