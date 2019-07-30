@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col s12 m6">
            @yield('runs')
            @yield('user')
        </div>

        <div class="col s12 m6">
            @yield('coffees')
            @yield('cups')
        </div>
    </div>
@endsection
