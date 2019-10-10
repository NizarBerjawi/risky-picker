@extends('layouts.dashboard')

@section('content')
    <form action="{{ route('users.coffees.destroy', ['user' => $user, 'userCoffee' => $userCoffee]) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this user's coffee?</p>

        <a href="{{ route('users.coffees.index', compact('user')) }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">No</a>
        <button class="btn waves-effect waves-light">Yes</button>
    </form>
@endsection
