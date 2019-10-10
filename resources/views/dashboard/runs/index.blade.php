@extends('layouts.dashboard')

@section('title', 'Coffee Runs')

@section('content')
    @include('dashboard.runs.table')

    @isset($countdown)
        <div class="right-align"><small>(Next run is {{ $countdown }})</small></div>
    @endisset
@endsection
