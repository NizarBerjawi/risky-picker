@extends('layouts.dashboard')

@section('title', 'User Coffee')

@section('content')
    @include('admin.users.coffees.form', [
        'action'  => route('users.coffees.store', $user),
        'method'  => 'POST',
        'enabled' => true
    ])
@endsection
