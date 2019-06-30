@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>View Coffee Run</h3>

        @success
            @alert('success')
        @endsuccess

        <div class="row">
            @include('dashboard.runs.form')
        </div>
    </div>
@endsection
