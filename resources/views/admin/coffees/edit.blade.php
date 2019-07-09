@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('admin.coffees.form', [
            'action' => route('coffees.update', $coffee),
            'method' => 'PUT',
        ])
    </div>
@endsection
