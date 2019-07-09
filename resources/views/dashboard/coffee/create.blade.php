@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('dashboard.coffee.form', [
            'action' => route('dashboard.coffee.store', request()->all()),
            'method' => 'POST',
        ])
    </div>
@endsection
