@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.cups.create') }}>Add</a>
        </div>

        @include('dashboard.cups.table')

        <div class="center-align">
            {{ $cups->links() }}
        </div>
    </div>
@endsection
