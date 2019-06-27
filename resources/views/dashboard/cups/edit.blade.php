@extends('layouts.base')

@section('content')
    <div class="section">
        @success
            @alert('success')
        @endsuccess

        @include('dashboard.cups.form', [
            'action' => route('dashboard.cups.update', $cup),
            'method' => 'PUT',
        ])
    </div>
@endsection
