@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    <form action="{{ route('dashboard.coffee.delete', $userCoffee) }}" method="POST">
        @csrf
        @method('DELETE')

        <p>Are you sure you want to delete this coffee?</p>

        <a href="{{ route('dashboard.coffee.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">No</a>
        <button class="btn waves-effect waves-light">Yes</button>
    </form>
@endsection
