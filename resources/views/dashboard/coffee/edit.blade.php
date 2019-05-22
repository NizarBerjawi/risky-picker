@extends('layouts.base')

@section('content')
    <div class="section">
        @errors
            @alert('errors')
        @enderrors

        @include('dashboard.coffee.form', [
            'action' => route('dashboard.coffee.update', $userCoffee),
            'method' => 'PUT',
        ])
    </div>
@endsection
