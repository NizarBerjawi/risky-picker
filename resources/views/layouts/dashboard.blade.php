@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col s12 m6">
            @yield('runs')
        </div>

        <div class="col s12 m6">
            @yield('coffees')
        </div>
    </div>

    <div class="row">
        <div class="col s12 m6">
            @yield('user')
        </div>

        <div class="col s12 m6">
            @yield('cups')
        </div>
    </div>
@endsection
