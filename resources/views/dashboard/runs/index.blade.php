@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        <div class="row">
            @include('dashboard.runs.table')
        </div>

        <div class="row center-align">
            {{ $runs->links() }}
        </div>
    </div>
@endsection
