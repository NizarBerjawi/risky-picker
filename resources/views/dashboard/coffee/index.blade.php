@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    <div class="right-align">
        <a class="waves-effect waves-light btn-small" href={{ route('dashboard.coffee.create') }}>Add</a>
    </div>

    @include('dashboard.coffee.table')
@endsection
