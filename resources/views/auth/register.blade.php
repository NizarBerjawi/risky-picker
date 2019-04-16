@extends('layouts.base')

@section('content')
  <h3>{{ __('Register') }}</h3>

  @if(session()->has('success'))
      @include('partials.success', [
          'message' => session('success')->first()
      ])
  @endif
  <div class="row">

    <form action="{{ route('register') }}" method="POST">
      @csrf

      <div class="row">
          <div class="input-field col s12">
              <input id="name" type="text" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" type="text" name="name" value="{{ old('name') }}" required >
              <label for="name">{{ __('Name') }}</label>
              @if($errors->has('name'))
                  <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
              @endif
          </div>
      </div>

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
          <div class="input-field col s12">
              <input id="password-confirm" type="password" name="password_confirmation" required>
              <label for="password-confirm">{{ __('Confirm Password') }}</label>
          </div>
      </div>

      <div class="row">
          <div class="col s12 right-align">
              <a href={{ route('coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>

              <button class="btn waves-effect waves-light" type="submit">{{ __('Register') }}
                  <i class="material-icons right">send</i>
              </button>
          </div>
      </div>
    </form>
  </div>
@endsection
