@extends('layouts.base')

@section('content')
  <h3>{{ __('Register') }}</h3>

  @success
      @alert('success')
  @endsuccess

  <div class="row">
    <form action="{{ request()->fullUrl() }}" method="POST">
      @csrf

      <div class="row">
          <div class="input-field col s12">
              <input id="first_name" type="text" class="{{ $errors->has('first_name') ? 'invalid' : 'validate' }}" type="text" name="first_name" value="{{ old('first_name') }}" required >
              <label for="first_name">{{ __('First Name') }}</label>
              @validation('first_name')
          </div>
      </div>

      <div class="row">
          <div class="input-field col s12">
              <input id="last_name" type="text" class="{{ $errors->has('last_name') ? 'invalid' : 'validate' }}" type="text" name="last_name" value="{{ old('last_name') }}" required >
              <label for="last_name">{{ __('Last Name') }}</label>
              @validation('last_name')
          </div>
      </div>

      <div class="row">
          <div class="input-field col s12">
              <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ old('email') }}" required >
              <label for="email">{{ __('E-Mail Address') }}</label>
              @validation('email')
          </div>
      </div>

      <div class="row">
          <div class="input-field col s12">
              <input id="password" type="password" class="{{ $errors->has('password') ? 'invalid' : 'validate' }}" name="password" required>
              <label for="password">{{ __('Password') }}</label>
              @validation('password')
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

              <button class="btn waves-effect waves-light" type="submit">{{ __('Register') }}</button>
          </div>
      </div>
    </form>
  </div>
@endsection
