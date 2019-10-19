@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('admin.coffees.form', [
        'action' => route('admin.coffees.store'),
        'method' => 'POST',
        'enabled' => true,
    ])
@endsection
