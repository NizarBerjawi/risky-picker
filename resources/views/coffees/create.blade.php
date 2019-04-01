@extends('layouts.base')

@section('content')
    <h3>Create Coffee</h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif
    
    <div class="row">
        @include('coffees.form', [
            'action' => route('coffees.store'),
            'method' => 'post',
        ])
    </div>
@endsection
