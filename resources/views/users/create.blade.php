@extends('layouts.base')

@section('content')
    <h3>Create User</h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif
    
    <div class="row">
        @include('users.form', [
            'action' => route('users.store'),
            'method' => 'post',
        ])
    </div>
@endsection
