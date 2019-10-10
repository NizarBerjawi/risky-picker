@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    <form action="{{ route('schedules.delete', $schedule) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this schedule?</p>

        <a href="{{ route('schedules.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">No</a>
        <button class="btn waves-effect waves-light">Yes</button>
    </form>
@endsection
