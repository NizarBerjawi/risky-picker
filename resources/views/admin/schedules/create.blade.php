@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    @include('admin.schedules.form', [
        'action'  => route('schedules.store'),
        'method'  => 'POST',
        'enabled' => true,
    ])
@endsection
