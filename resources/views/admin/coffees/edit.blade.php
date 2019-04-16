@extends('layouts.base')

@section('content')
    <h3>Update Coffee</h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        @include('admin.coffees.form', [
            'action' => route('coffees.update', $coffee),
            'method' => 'put',
        ])
    </div>
@endsection
