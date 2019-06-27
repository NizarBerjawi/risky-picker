@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Update User</h3>

        @success
            @alert('success')
        @endsuccess

        <div class="row">
            @include('admin.users.form', [
                'action' => route('users.update', $user),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
