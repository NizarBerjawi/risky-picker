@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        @if (request()->user()->doesnttHaveCup())
            <div class="right-align">
                <a class="waves-effect waves-light btn-small" href={{ route('dashboard.cups.create') }}>Add</a>
            </div>
        @endif

        @include('dashboard.cups.table')
    </div>
@endsection
