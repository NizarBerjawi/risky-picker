@extends('layouts.base')

@section('content')
    <div class="section">
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
