@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
    @include('dashboard.user.form', [
        'enabled' => false,
        'action' => null,
    ])

    <div class="row">
        <div class="col s12">
            <div class="card center-align">
                <div class="card-content">
                    <span class="card-title">Caution!</span>
                    <a href="{{ route('dashboard.profile.confirm-delete', $user) }}" class="btn waves-effect waves-light red"><i class="material-icons left">delete_forever</i>{{ __('Delete My Account') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
