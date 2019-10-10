@extends('layouts.dashboard')

@section('title', 'Cups')

@section('content')
    @include('dashboard.cups.form', [
        'action'  => route('dashboard.cups.store'),
        'method'  => 'POST',
        'enabled' => true,
    ])
@endsection
