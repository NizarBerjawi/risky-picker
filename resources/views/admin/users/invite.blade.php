@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>Invite users</h3>

        @success
            @alert('success')
        @endsuccess

        <form action="{{ route('users.invite') }}" method="POST">
            @csrf

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" name="email" value="{{ old('email') }}">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    @validation('email')
                </div>
            </div>

            <div class="right-align">
                <a href={{ route('users.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
                <button class="btn waves-effect waves-light" type="submit">{{ __('Invite') }}</button>
            </div>
        </form>
    </div>
@endsection