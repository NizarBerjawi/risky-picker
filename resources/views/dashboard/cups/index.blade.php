@extends('layouts.dashboard')

@section('title', 'Cups')

@section('content')
    @if (request()->user()->doesntHaveCup())
        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.cups.create') }}>Add</a>
        </div>
    @endif

    @include('dashboard.cups.table')
@endsection
