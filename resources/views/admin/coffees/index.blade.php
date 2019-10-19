@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    <div class="right-align">
        <a href={{ route('admin.coffees.create') }} class="btn-small waves-effect waves-light">Add</a>
    </div>

    @include('admin.coffees.table')
@endsection
