@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('admin.coffees.form', [
        'enabled' => false,
    ])
@endsection
