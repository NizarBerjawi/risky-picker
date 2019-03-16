<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Food Picker</title>
    <link rel="stylesheet" href="/css/materialize.min.css">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style media="screen">

        /* label color */
        .input-field label {
            color: #000;
        }
        /* label focus color */
        .input-field input[type=text]:focus + label {
            color: #000;
        }
        /* label underline focus color */
        .input-field input[type=text]:focus {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }
        /* valid color */
        .input-field input[type=text].valid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }
        /* invalid color */
        .input-field input[type=text].invalid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }
        /* icon prefix focus color */
        .input-field .prefix.active {
            color: #000;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col m8 s12 offset-m2">
                @yield('content')
            </div>
        </div>

        @include('partials.options')
    </div>

    @yield('modals')

    <script src="/js/materialize.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
          var elems = document.querySelectorAll('.fixed-action-btn');
          var instances = M.FloatingActionButton.init(elems, {});
        });
    </script>

    @yield('scripts')
</body>
</html>
