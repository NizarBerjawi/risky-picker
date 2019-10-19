@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    @include('admin.schedules.form', [
        'action'  => route('admin.schedules.update', $schedule),
        'method'  => 'PUT',
        'enabled' => true,
    ])
@endsection
