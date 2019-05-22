@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Update Coffee</h3>

        @include('admin.coffees.form', [
            'action' => route('coffees.update', $coffee),
            'method' => 'PUT',
        ])
    </div>
@endsection
