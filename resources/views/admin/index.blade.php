@extends('layouts.base')

@section('content')
    <h3>The Picker</h3>
    @errors
        @alert('errors')
    @enderrors

    @success
         @alert('success')
    @endsuccess

    <div class="row">
        <form action="{{ route('pick') }}" method="POST" class="col s12">
            @csrf

            <div class="row">
                <div class="input-field col s12">
                  <select name="users[]" multiple>
                    @foreach($users as $user)
                        <option value="{{ $user->slug }}" selected>{{ $user->first_name }}</option>
                    @endforeach
                  </select>
                  <label>Who's in the office today?</label>
                </div>
            </div>

            <div class="row">
                <button class="btn waves-effect waves-light" type="submit">Pick</button>
            </div>
        </form>
    </div>
@endsection
