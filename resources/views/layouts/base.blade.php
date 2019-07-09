<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ webpack('common', 'css') }}" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
    @include('partials.navbar')

    <div class="container">
        <div class="row">
            <div class="col m1 s12">
                @yield('left')
            </div>

            <div class="col m10 s12">
                @yield('content')
            </div>

            <div class="col m1 s12">
                @yield('right')
            </div>
        </div>

        @includeWhen(Auth::check(), 'partials.options')
    </div>

    @yield('modals')

    <script type="text/javascript" src="{{ webpack('vendor') }}"></script>
    <script type="text/javascript" src="{{ webpack('common') }}"></script>
    <script type="text/javascript" src="{{ webpack('app') }}"></script>

    @yield('scripts')
</body>
</html>
