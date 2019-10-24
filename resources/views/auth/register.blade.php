@extends('layouts.base')

@section('content')
<div class="section">
    <div class="col s12 m10 l8  offset-m1 offset-l2">
        <div class="card-panel">
            <div class="card-content">
                <h4 class="card-title">{{ __('Register') }}</h4>

                @if($user && $user->trashed())
                <ul class="collection deep-orange lighten-5">
                    <li class="collection-item deep-orange lighten-5">
                        <div class="col m1 s12 center-align">
                            <i class="material-icons">warning</i>
                        </div>

                        <div class="col m11 s12">
                            You have previously registered an account. All your data will be restored
                        </div>
                    </li>
                </ul>
                @endif

                <form action="{{ request()->fullUrl() }}" method="POST">
                @csrf

                <div class="row">
                    <div class="input-field col s12">
                        <input id="first_name" type="text" class="{{ $errors->has('first_name') ? 'invalid' : 'validate' }}" type="text" name="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" readonly required >
                        <label for="first_name">{{ __('First Name') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="last_name" type="text" class="{{ $errors->has('last_name') ? 'invalid' : 'validate' }}" type="text" name="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" readonly required >
                        <label for="last_name">{{ __('Last Name') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ request()->get('email') }}" readonly>
                        <label for="email">{{ __('E-Mail Address') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="password" type="password" class="{{ $errors->has('password') ? 'invalid' : 'validate' }}" name="password" required>
                        <label for="password">{{ __('Password') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="password-confirm" type="password" name="password_confirmation" required>
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12 right-align">
                        <a href={{ route('login') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
                        <button class="btn waves-effect waves-light" type="submit">{{ __('Register') }}</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
