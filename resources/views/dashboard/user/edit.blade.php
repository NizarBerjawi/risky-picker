@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        @include('dashboard.user.form')
    </div>
@endsection
