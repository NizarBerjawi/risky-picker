@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.coffee.create') }}>Add</a>
        </div>

        @include('dashboard.coffee.table')

        <div class="center-align">
            {{ $coffees->links() }}
        </div>
    </div>
@endsection
