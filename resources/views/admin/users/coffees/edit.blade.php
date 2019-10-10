@extends('layouts.dashboard')

@section('title', 'User Coffee')

@section('content')
    @include('admin.users.coffees.form', [
        'action'  => route('users.coffees.update', compact('user', 'userCoffee')),
        'method'  => 'PUT',
        'enabled' => true
    ])
@endsection
