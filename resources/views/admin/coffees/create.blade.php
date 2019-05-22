@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Create Coffee</h3>

        @include('admin.coffees.form', [
            'action' => route('coffees.store'),
            'method' => 'POST',
        ])
    </div>
@endsection
