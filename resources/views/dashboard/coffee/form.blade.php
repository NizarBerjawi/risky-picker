<form action="{{ $action ?? '' }}" method="POST">
    @if ($enabled ?? false)
        @csrf
        @method($method ?? 'GET')
    @endif

    <div class="row">
        <div class="input-field col s12">
            <select name="coffee_id" class="{{ $errors->has('coffee_id') ? 'invalid' : 'validate' }}" {{ ($enabled ?? false) ?: 'disabled' }}>
                <option value="" disabled selected>{{ ($adhoc ?? false) ? 'Trying something different?' : 'Choose your coffee' }}</option>
                @foreach($coffees as $coffee)
                    <option value="{{ $coffee->id }}" {{ ($userCoffee->coffee->id ?? old('coffee_id')) == $coffee->id ? "selected='selected'" : "" }}>{{ $coffee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-field col s12">
            <select name="sugar" class="{{ $errors->has('sugar') ? 'invalid' : 'validate' }}" {{ ($enabled ?? false) ?: 'disabled' }}>
                @foreach($sugars as $number => $sugar)
                    <option value="{{ $number }}" {{ ($userCoffee->sugar ?? old('sugar')) == $number ? 'selected="selected"' : '' }}>{{ $sugar }}</option>
                @endforeach
            </select>
        </div>

        @if (!($adhoc ?? false))
        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker {{ $errors->has('start_time') ? 'invalid' : 'validate' }}" name="start_time" value="{{ $userCoffee->start_time ?? old('start_time') }}" placeholder="From" {{ ($enabled ?? false) ?: 'disabled' }}>
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker {{ $errors->has('end_time') ? 'invalid' : 'validate' }}" name="end_time" value="{{ $userCoffee->end_time ?? old('end_time') }}" placeholder="To" {{ ($enabled ?? false) ?: 'disabled' }}>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="days[]" class="{{ $errors->has('days') ? 'invalid' : 'validate' }}" multiple {{ ($enabled ?? false) ?: 'disabled' }}>
                    @foreach(days() as $key => $day)
                        <option value="{{ $key }}" {{ in_array($key, old('days', $userCoffee->days ?? [])) ? "selected='selected'" : "" }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>
      @endif
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('dashboard.coffee.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>Back</a>
            @if ($enabled ?? false)
                <button class="btn waves-effect waves-light" type="submit"><i class="material-icons left">save</i>Save</button>
            @endif
        </div>
    </div>
</form>
