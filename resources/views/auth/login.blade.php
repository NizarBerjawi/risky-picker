@extends('layouts.base')

@section('content')
    <div class="section">
        <h3>{{ __('Login') }}</h3>

        @include('partials.validation')

        <div class="row">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="input-field col s12">
                        <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ old('email') }}" required >
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
                    <div class="col s12 right-align">
                        <button class="btn waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                    </div>
                    {{-- <div class="col s12 right-align">
                        @if (Route::has('password.request'))
                            <a class="" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
