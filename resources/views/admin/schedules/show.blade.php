@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    @include('admin.schedules.form', [
        'enabled' => false,
    ])
@endsection
