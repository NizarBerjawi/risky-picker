@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    <div class="right-align">
        <a href={{ route('admin.schedules.create') }} class="btn-small waves-effect waves-light">New Schedule</a>
    </div>

    @include('admin.schedules.table')
@endsection
