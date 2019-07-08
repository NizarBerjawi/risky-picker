@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        <div class="row">
            <div class="right-align">
                <a href={{ route('users.coffees.create', $user) }} class="btn-small waves-effect waves-light">Add</a>
            </div>

            @include('admin.users.coffees.table')
        </div>

        <div class="row center-align">
            {{ $coffees->links() }}
        </div>
    </div>
@endsection
