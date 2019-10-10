@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <div class="right-align">
        <a href={{ route('users.invitation') }} class="btn-small waves-effect waves-light">Invite</a>
    </div>

    @include('admin.users.table')
@endsection
