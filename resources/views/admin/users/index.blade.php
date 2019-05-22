@extends('layouts.base')

@section('content')
    <h3>Users</h3>

    @success
        @alert('success')
    @endsuccess

    <div class="row">
        <div class="right-align">
            <a href={{ route('users.invitation') }} class="btn-small waves-effect waves-light">Invite</a>
        </div>

        @include('admin.users.table')
    </div>

    <div class="row center-align">
        {{ $users->links() }}
    </div>
@endsection
