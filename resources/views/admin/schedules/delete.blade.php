@extends('layouts.dashboard')

@section('title', 'Schedules')

@section('content')
    <form action="{{ route('admin.schedules.delete', $schedule) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this schedule?</p>

        <a href="{{ route('admin.schedules.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>Back</a>
        <button class="btn waves-effect waves-light"><i class="material-icons left">delete_forever</i>Delete</button>
    </form>
@endsection
