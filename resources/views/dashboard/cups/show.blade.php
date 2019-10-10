@extends('layouts.dashboard')

@section('title', 'Cups')

@section('content')
    @include('dashboard.cups.form', [
        'enabled' => false,
    ])
@endsection
