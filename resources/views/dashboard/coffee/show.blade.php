@extends('layouts.dashboardboard')

@section('title', 'Coffees')

@section('content')
    @include('dashboard.coffee.form', [
        'enabled' => false,
    ])
@endsection
