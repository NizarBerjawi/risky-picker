<nav class="nav-extended">
    <div class="nav-wrapper">
        <a href="{{ Auth::check() ? route('dashboard.index') : route('home') }}" class="brand-logo center">Risky Picker</a>
        <ul class="right hide-on-med-and-down">
            @auth
                <li><a href="{{ route('logout') }}" class="waves-effect waves-light btn" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout
                </a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @endguest
        </ul>
    </div>

    @auth
        @onadmin
        <div class="nav-content white">
            <div class="row">
                <ul class="tabs tabs-fixed-width col m8 s12 offset-m2">
                    <li class="tab col s3"><a target="_self" class="{{ Route::is('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a></li>
                    <li class="tab col s3"><a target="_self" class="{{ Route::is('coffees.*') ? 'active' : '' }}" href="{{ route('coffees.index') }}">Coffees</a></li>
                    <li class="tab col s3"><a target="_self" class="{{ Route::is('schedules.*') ? 'active' : '' }}" href="{{ route('schedules.index') }}">Schedules</a></li>
                </ul>
            </div>
        </div>
        @endonadmin
    @endauth
</nav>
