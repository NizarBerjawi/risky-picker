@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    @include('admin.users.form', [
        'action' => route('admin.users.update', $user),
        'method' => 'PUT',
        'enabled' => true,
    ])
@endsection
