@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('dashboard.user.form')
    </div>
@endsection
