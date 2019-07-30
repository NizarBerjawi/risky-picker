@extends('layouts.base')

@section('validation')
    @include('partials.validation')
@endsection

@section('content')
    <div class="row">
        <div class="card-panel">
            <div class="card-content">
                <h4 class="card-title">{{ __('Edit User') }}</h4>

                @include('admin.users.form', [
                    'action' => route('users.update', $user),
                    'method' => 'PUT',
                ])
            </div>
        </div>
    </div>
@endsection
