
@auth
<div class="container">
    <a href="#" data-target="slide-out" class="top-nav sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
</div>
@endauth

<nav class="top-nav">
    <div class="nav-wrapper">
        @auth
            <div class="container">
                <div class="nav-wrapper">
                    <div class="row">
                        <div class="col s12">
                        <h1 class="header">@yield('title', 'Coffee Picker')</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endauth

        @guest
            <div class="row">
                <div class="col s12 m10 offset-m1">
                    <a href="{{ Auth::check() ? route('dashboard.profile.index') : route('home') }}" class="brand-logo center">Risky Picker</a>
                </div>
            </div>
        @endguest
    </div>
</nav>
