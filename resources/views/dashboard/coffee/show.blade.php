@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('dashboard.coffee.form', [
        'enabled' => false,
    ])
@endsection
