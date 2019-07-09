@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('dashboard.coffee.form', [
            'action' => route('dashboard.coffee.update', $userCoffee),
            'method' => 'PUT',
        ])
    </div>
@endsection
