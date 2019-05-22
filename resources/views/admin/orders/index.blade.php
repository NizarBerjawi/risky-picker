@extends('layouts.base')

@section('content')
    <h3>Orders</h3>

    @success
        @alert('success')
    @endsuccess

    <div class="row">
        @foreach($users as $user)
          <div>Name: {{ $user->name }}</div>

          <img class="materialboxed" width="250" src="{{ $user->cup->file_path }}">
        @endforeach
    </div>

    <div class="row center-align">
        {{ $users->links() }}
    </div>
@endsection
