@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        <div class="row">
            @include('admin.users.coffees.form', [
                'action' => route('users.coffees.update', compact('user', 'userCoffee')),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
