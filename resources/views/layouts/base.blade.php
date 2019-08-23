<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ webpack('common', 'css') }}" type="text/css">
</head>

<body>
    @include('partials.navbar')

    <div class="container">
        <div class="row">
            @include('partials.validation')
        </div>

        <div class="row">
            @yield('content')
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
