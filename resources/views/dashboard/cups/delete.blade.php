@extends('layouts.dashboard')

@section('title', 'Cups')

@section('content')
    <form action="{{ route('dashboard.cups.delete', $cup) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this cup?</p>

        <a href="{{ route('dashboard.cups.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>Back</a>
        <button class="btn waves-effect waves-light"><i class="material-icons left">delete_forever</i>Delete</button>
    </form>
@endsection
