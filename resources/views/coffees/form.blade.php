<form action={{ $action }} method="post">
    {{ csrf_field() }}
    {{ method_field($method) }}

    <div class="row">
        <div class="col s12">
            <div class="input-field">
                <select name="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" {{ !empty($disabled) ? 'disabled' : ''}}>
                    <option value="" disabled selected>My coffee of choice is a</option>
                    @foreach($coffees as $coffee)
                        <option value="{{ $coffee->slug }}" {{ ($userCoffee->coffee->slug ?? old('name')) === $coffee->slug ? "selected='selected'" : "" }}>{{ $coffee->name }}</option>
                    @endforeach
                </select>

                @if(empty($disabled) && $errors->has('name'))
                    <span class="helper-text red-text">{{ $errors->first('name') }}</span>
                @endif
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="sugar" class="{{ $errors->has('sugar') ? 'invalid' : 'validate' }}" {{ !empty($disabled) ? 'disabled' : ''}}>
                    @foreach($sugars as $number => $sugar)
                        <option value="{{ $number }}" {{ ($userCoffee->sugar ?? old('sugar')) === $number ? 'selected="selected"' : '' }}>{{ $sugar }}</option>
                    @endforeach
                </select>

                @if(empty($disabled) && $errors->has('sugar'))
                    <span class="helper-text red-text">{{ $errors->first('sugar') }}</span>
                @endif
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker{{ $errors->has('start_time') ? ' invalid' : ' validate' }}" name="start_time" value="{{ $userCoffee->start_time ?? old('start_time') }}" placeholder="From" {{ !empty($disabled) ? 'disabled' : ''}}>
                @if(empty($disabled) && $errors->has('start_time'))
                    <span class="helper-text red-text">{{ $errors->first('start_time') }}</span>
                @endif
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker{{ $errors->has('end_time') ? ' invalid' : ' validate' }}" name="end_time" value="{{ $userCoffee->end_time ?? old('end_time') }}" placeholder="To" {{ !empty($disabled) ? 'disabled' : ''}}>
                @if(empty($disabled) && $errors->has('end_time'))
                    <span class="helper-text red-text">{{ $errors->first('end_time') }}</span>
                @endif
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="days[]" class="{{ $errors->has('days') ? 'invalid' : 'validate' }}" multiple {{ !empty($disabled) ? 'disabled' : ''}}>
                    @foreach($days as $key => $day)
                        <option value="{{ $key }}" {{ isset($userCoffee) && $userCoffee->days->contains($key) ? "selected='selected'" : "" }}>{{ $day }}</option>
                    @endforeach
                </select>
                @if(empty($disabled) && $errors->has('days'))
                    <span class="helper-text red-text">{{ $errors->first('days') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
          @if(empty($disabled))
            <a href={{ route('coffees.index', $user) }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
            <button class="btn waves-effect waves-light" type="submit">{{ $label }}
                <i class="material-icons right">send</i>
            </button>
          @else
              <a href={{ route('users.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Back</a>
              <a href={{ route('coffees.edit', compact('user', 'userCoffee')) }} class="btn waves-effect waves-light">Edit</a>
          @endif
        </div>
    </div>

</form>
