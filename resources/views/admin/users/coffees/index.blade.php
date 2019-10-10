@extends('layouts.dashboard')

@section('content')
    <div class="right-align">
        <a href={{ route('users.coffees.create', $user) }} class="btn-small waves-effect waves-light">Add</a>
    </div>

    @include('admin.users.coffees.table')

    <div class="row center-align">
        {{ $coffees->links() }}
    </div>
@endsection
