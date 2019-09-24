@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>{{ __('View Coffee Run') }}</h3>
        @include('partials.validation')

        <div class="row">
            @include('partials.coffees')
        </div>
    </div>
@endsection
