@extends('layouts.base')

@section('content')
    <h3>Update User</h3>

    <div class="row">
        @include('admin.users.form', [
            'action' => route('users.update', $user),
            'method' => 'PUT',
        ])
    </div>
@endsection
