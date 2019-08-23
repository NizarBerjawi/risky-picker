@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Create a Coffee') }}</h5>
                @include('admin.coffees.form', [
                    'action' => route('coffees.store'),
                    'method' => 'POST',
                ])
            </div>
        </div>
    </div>
@endsection
