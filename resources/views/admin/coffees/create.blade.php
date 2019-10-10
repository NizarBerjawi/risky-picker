@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('admin.coffees.form', [
        'action' => route('coffees.store'),
        'method' => 'POST',
    ])
@endsection
