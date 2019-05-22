<nav class="nav-extended">
    <div class="nav-wrapper">
        <a href="{{ route('home') }}" class="brand-logo center">Risky Picker</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            @guest
                <li><a class="waves-effect waves-light btn" href="{{ route('login') }}">Login</a></li>
            @else
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
    <div class="nav-content white">
        <div class="row">
            <ul class="tabs tabs-fixed-width col m8 s12 offset-m2">
            @onadmin
                <li class="tab col s3"><a target="_self" class="{{ Route::is('picker') ? 'active' : '' }}" href="{{ route('picker') }}">Picker</a></li>
                <li class="tab col s3"><a target="_self" class="{{ Route::is('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">Users</a></li>
                <li class="tab col s3"><a target="_self" class="{{ Route::is('coffees.index') ? 'active' : '' }}" href="{{ route('coffees.index') }}">Coffees</a></li>
            @endonadmin

            @ondashboard
                <li class="tab col s3"><a target="_self" class="{{ Route::is('dashboard.profile.edit') ? 'active' : '' }}" href="{{ route('dashboard.profile.edit') }}">Personal Details</a></li>
                <li class="tab col s3"><a target="_self" class="{{ Route::is('dashboard.coffee.index') ? 'active' : '' }}" href="{{ route('dashboard.coffee.index') }}">Coffee</a></li>
                <li class="tab col s3"><a target="_self" class="{{ Route::is('dashboard.cups.index') ? 'active' : '' }}" href="{{ route('dashboard.cups.index') }}">Cups</a></li>
            @endondashboard
            </ul>
        </div>
    </div>
    @endauth
</nav>

<ul class="sidenav" id="mobile-demo">
</ul>
