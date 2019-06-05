@extends('layouts.base')

@section('content')
    <div class="section">
        {{-- @errors
            @alert('errors')
        @enderrors --}}

        @include('dashboard.coffee.form', [
            'action' => route('dashboard.coffee.store', request()->all()),
            'method' => 'POST',
        ])
    </div>
@endsection
