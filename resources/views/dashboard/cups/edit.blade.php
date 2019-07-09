@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        @include('dashboard.cups.form', [
            'action' => route('dashboard.cups.update', $cup),
            'method' => 'PUT',
        ])
    </div>
@endsection
