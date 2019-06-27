@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Create Coffee</h3>

        @success
            @alert('success')
        @endsuccess

        <div class="row">
            @include('admin.users.coffees.form', [
                'action' => route('users.coffees.store', $user),
                'method' => 'POST',
            ])
        </div>
    </div>
@endsection
