@extends('layouts.base')

@section('content')
    <h3>Select Coffee</h3>

    <div class="row">
        @include('users.coffees.form', [
            'action' => route('users.coffees.store', $user),
            'method' => 'post',
        ])
    </div>
@endsection
