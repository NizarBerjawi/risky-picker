@extends('layouts.base')

@section('content')
    <h3>The Picker</h3>

    @if(session()->has('warning'))
        @include('partials.warning', [
            'message' => session('warning')->first()
        ])
    @endif

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        <form action="{{ route('pick') }}" method="POST" class="col s12">
            {{ csrf_field() }}

            <div class="row">
                <div class="input-field col s12">
                  <select name="users[]" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->slug }}" selected>{{ $user->name }}</option>
                    @endforeach
                  </select>
                  <label>Who's in the office today?</label>
                </div>

                <div class="input-field col s12">
                  <select name="type">

                    @foreach($types as $type)
                        <option value="{{ $type->slug }}" {{ old('type') === $type->slug ? 'selected="selected"' : '' }}>{{ $type->display_name }}</option>
                    @endforeach
                  </select>
                  <label>What are you getting?</label>
                </div>
            </div>

            <div class="row">
                <button class="btn waves-effect waves-light" type="submit">Pick</button>
            </div>
        </form>
    </div>
@endsection
