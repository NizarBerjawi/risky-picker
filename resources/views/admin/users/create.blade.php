@extends('layouts.base')

@section('content')
    <h3>Create User</h3>

    <div class="row">
        @include('admin.users.form', [
            'action' => route('users.store'),
            'method' => 'POST',
        ])
    </div>
@endsection
