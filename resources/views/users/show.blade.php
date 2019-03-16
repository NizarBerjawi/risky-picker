@extends('layouts.base')

@section('content')
    <h3>Update User</h3>

    <div class="row">
        @include('users.form', [
            'disabled' => true,
        ])
    </div>
@endsection
