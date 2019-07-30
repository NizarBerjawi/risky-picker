@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Edit Profile') }}</h5>

                @include('dashboard.user.form', [
                    'enabled' => true,
                    'method' => 'PUT',
                ])
            </div>
        </div>
    </div>
@endsection
