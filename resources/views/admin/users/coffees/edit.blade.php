@extends('layouts.base')

@section('content')
    <h3>Edit Coffee</h3>

    <div class="row">
        @include('admin.users.coffees.form', [
            'action' => route('users.coffees.update', compact('user', 'userCoffee')),
            'method' => 'PUT',
        ])
    </div>
@endsection
