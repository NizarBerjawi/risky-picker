@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('admin.coffees.form', [
        'action' => route('admin.coffees.update', $coffee),
        'method' => 'PUT',
        'enabled' => true,
    ])
@endsection
