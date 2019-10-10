@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <form action="{{ route('users.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this user?</p>

        <a href="{{ route('users.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">No</a>
        <button class="btn waves-effect waves-light">Yes</button>
    </form>
@endsection
