@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('admin.coffees.form', [
            'action' => route('coffees.store'),
            'method' => 'POST',
        ])
    </div>
@endsection
