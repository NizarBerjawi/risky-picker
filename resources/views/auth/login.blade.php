@extends('layouts.base')

@section('validation')
    @include('partials.validation')
@endsection

@section('content')
    <div class="section">
        <div class="col s12 m10 l8  offset-m1 offset-l2">
            <div class="card-panel">
                <div class="card-content">
                    <h4 class="card-title">{{ __('Login') }}</h4>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="email" type="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ old('email') }}">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input id="password" type="password" class="{{ $errors->has('password') ? 'invalid' : 'validate' }}" name="password">
                                <label for="password">{{ __('Password') }}</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 right-align">
                                <button class="btn waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
