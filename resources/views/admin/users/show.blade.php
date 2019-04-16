@extends('layouts.base')

@section('content')
    <h3>Update User</h3>

    <div class="row">
        @include('admin.users.form', ['disabled' => true])
    </div>
@endsection
