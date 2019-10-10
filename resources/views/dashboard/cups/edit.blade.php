@extends('layouts.dashboard')

@section('title', 'Cups')

@section('content')
    @include('dashboard.cups.form', [
        'action'  => route('dashboard.cups.update', $cup),
        'method'  => 'PUT',
        'enabled' => true,
    ])
@endsection
