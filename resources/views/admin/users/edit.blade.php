@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h4 class="card-title">{{ __('Edit this user') }}</h4>

                @include('admin.users.form', [
                    'action' => route('users.update', $user),
                    'method' => 'PUT',
                ])
            </div>
        </div>
    </div>
@endsection
