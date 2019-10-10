@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
    @include('dashboard.user.form', [
        'enabled' => true,
        'action' => route('dashboard.profile.update'),
        'method' => 'PUT',
    ])
@endsection
