@extends('layouts.dashboard')

@section('title', 'Coffee Runs')

@section('content')
    <div class="right-align">
        <a class="waves-effect waves-light btn-small" href={{ route('dashboard.runs.statistics') }}><i class="material-icons left">library_books</i>Statistics</a>
    </div>

    @include('dashboard.runs.table')

    @isset($countdown)
        <div class="right-align"><small>(Next run is {{ $countdown }})</small></div>
    @endisset
@endsection
