@extends('layouts.base')

@section('content')
    <h3>Create User</h3>

    <div class="row">
        @include('users.form', [
            'action' => route('users.store'),
            'method' => 'post',
            'label' => 'Add',
        ])
    </div>
@endsection
