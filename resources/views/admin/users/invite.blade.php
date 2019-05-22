@extends('layouts.base')

@section('content')
    <h3>Invite users</h3>
    <form action="{{ route('users.invite') }}" method="POST">
        @csrf

        <div class="row">
            <div class="input-field col s12">
                <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" name="email" value="{{ old('email') }}" required >
                <label for="email">{{ __('E-Mail Address') }}</label>
                @validation('email')
            </div>
        </div>

        <div class="right-align">
            <button class="btn waves-effect waves-light" type="submit">{{ __('Invite') }}</button>
        </div>
    </form>
@endsection
