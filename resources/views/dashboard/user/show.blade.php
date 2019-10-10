@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
    @include('dashboard.user.form', [
        'enabled' => false,
        'action' => null,
    ])
@endsection
