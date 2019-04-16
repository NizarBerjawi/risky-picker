@extends('layouts.base')

@section('content')
    <h3>Update User</h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        @include('admin.users.form', [
            'action' => route('users.update', $user),
            'method' => 'put',
        ])
    </div>
@endsection
