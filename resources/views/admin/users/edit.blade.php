@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    @include('admin.users.form', [
        'action' => route('users.update', $user),
        'method' => 'PUT',
    ])
@endsection
