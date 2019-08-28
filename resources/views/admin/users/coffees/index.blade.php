@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Coffees') }}</h5>

                <div class="right-align">
                    <a href={{ route('users.coffees.create', $user) }} class="btn-small waves-effect waves-light">Add</a>
                </div>

                @include('admin.users.coffees.table')
            </div>

            <div class="row center-align">
                {{ $coffees->links() }}
            </div>
        </div>
    </div>
@endsection
