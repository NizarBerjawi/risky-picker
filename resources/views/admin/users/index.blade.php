@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Users') }}</h5>

                <div class="right-align">
                    <a href={{ route('users.invitation') }} class="btn-small waves-effect waves-light">Invite</a>
                </div>

                @include('admin.users.table')
            </div>

            <div class="row center-align">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
