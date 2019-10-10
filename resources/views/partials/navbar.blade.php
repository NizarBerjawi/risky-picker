
<div class="container">
    <a href="#" data-target="slide-out" class="top-nav sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
</div>

<nav class="top-nav">
    <div class="nav-wrapper">
        @auth
            <div class="container">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12">
                        <h1 class="header">@yield('title', 'Picker')</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="nav-wrapper">
                <div class="row">
                    <div class="col s12 m10 offset-m1">
                        <a href="{{ Auth::check() ? route('dashboard.profile.index') : route('home') }}" class="brand-logo center">Risky Picker</a>
                    </div>
                </div>
            </div>
        @endguest
    </div>
</nav>

{{--
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
    @endauth --}}
