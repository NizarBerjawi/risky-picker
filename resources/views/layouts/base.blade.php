<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ webpack('common', 'css') }}" type="text/css">

    @yield('styles')
</head>

<body>
    <header>
        @include('partials.navbar')
    </header>

    @includeWhen(Auth::check(), 'partials.sidebar')

    <main>
        <div class="container">
            <div class="row">
                <div class="col s12">
                    @include('partials.validation')
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    @yield('content')
                </div>
            </div>

            @includeWhen(Auth::check(), 'partials.options')
        </div>

        @yield('modals')
    </main>

    <script type="text/javascript" src="{{ webpack('vendor') }}"></script>
    <script type="text/javascript" src="{{ webpack('common') }}"></script>

    @yield('scripts')
</body>
</html>
