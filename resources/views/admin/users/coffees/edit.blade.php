@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Edit Coffee</h3>

        @success
            @alert('success')
        @endsuccess

        <div class="row">
            @include('admin.users.coffees.form', [
                'action' => route('users.coffees.update', compact('user', 'userCoffee')),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
