@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    @include('admin.users.form', [
        'enabled' => false,
    ])
@endsection
