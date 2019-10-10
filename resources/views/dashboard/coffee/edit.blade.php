@extends('layouts.dashboard')

@section('content')
    @include('dashboard.coffee.form', [
        'action'  => route('dashboard.coffee.update', $userCoffee),
        'method'  => 'PUT',
        'enabled' => true,
    ])
@endsection
