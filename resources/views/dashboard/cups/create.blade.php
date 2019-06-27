@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        @include('dashboard.cups.form', [
            'action' => route('dashboard.cups.store'),
            'method' => 'POST',
        ])
    </div>
@endsection
