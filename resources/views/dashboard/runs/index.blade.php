@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        <div class="row">
            @include('dashboard.runs.table')
        </div>

        <div class="row center-align">
            {{ $runs->links() }}
        </div>
    </div>
@endsection
