@extends('layouts.base')

@section('content')
    <div class="row">
        <div class="col s12 m12 l6">
            @yield('user')
            @yield('cups')
        </div>

        <div class="col s12 m12 l6">
            @yield('coffees')
            @yield('runs')
        </div>
    </div>
@endsection
