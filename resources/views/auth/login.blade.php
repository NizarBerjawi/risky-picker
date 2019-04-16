@extends('layouts.base')

@section('content')
  <h3>{{ __('Login') }}</h3>

  @if(session()->has('success'))
      @include('partials.success', [
          'message' => session('success')->first()
      ])
  @endif

    <div class="row">
        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ old('email') }}" required >
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    @if($errors->has('email'))
                        <span class="helper-text" data-error="{{ $errors->first('email') }}"></span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <input id="password" type="password" class="{{ $errors->has('password') ? 'invalid' : 'validate' }}" name="password" required>
                    <label for="password">{{ __('Password') }}</label>
                    @if($errors->has('password'))
                        <span class="helper-text" data-error="{{ $errors->first('password') }}"></span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col s12 right-align">
                    <a href={{ route('coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>

                    <button class="btn waves-effect waves-light" type="submit">{{ __('Login') }}
                        <i class="material-icons right">send</i>
                    </button>

                    @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
