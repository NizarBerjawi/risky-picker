@extends('layouts.base')

@section('content')
    <div class="row center-align">
        <h1>{{ $user->name }}!!<h1>
        <h2> You have been picked!</h2>
    </div>

    <div class="row">
        <form class="col s12" action="{{ route('pick.confirm', compact('user')) }}" method="post">
            {{ csrf_field() }}

            <div class="col s12 center-align">
                <a href={{ route('pick') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Reject</a>
                <button class="btn waves-effect waves-light" type="submit">Confirm
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </form>
    </div>
@endsection
