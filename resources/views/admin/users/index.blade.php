@extends('layouts.dashboard')

@section('title', 'Users')

@section('content')
    <div class="right-align">
        <a href={{ route('admin.users.invitation') }} class="btn-small waves-effect waves-light"><i class="material-icons left">add</i>add</a>
    </div>

    @include('admin.users.table')
@endsection
