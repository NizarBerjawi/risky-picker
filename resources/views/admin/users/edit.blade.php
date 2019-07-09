@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        <div class="row">
            @include('admin.users.form', [
                'action' => route('users.update', $user),
                'method' => 'PUT',
            ])
        </div>
    </div>
@endsection
