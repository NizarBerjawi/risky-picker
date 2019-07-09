@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.coffee.create') }}>Add</a>
        </div>

        @include('dashboard.coffee.table')

        <div class="center-align">
            {{ $coffees->links() }}
        </div>
    </div>
@endsection
