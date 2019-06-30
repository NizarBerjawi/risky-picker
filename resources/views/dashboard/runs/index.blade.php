@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Coffee Runs</h3>

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
