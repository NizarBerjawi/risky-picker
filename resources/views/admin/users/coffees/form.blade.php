<form action={{ $action }} method="post">
    @csrf
    @method($method)

    <div class="row">
        <div class="col s12">
            <div class="input-field">
                <select name="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}">
                    <option value="" disabled selected>My coffee of choice is a</option>
                    @foreach($coffees as $coffee)
                        <option value="{{ $coffee->slug }}" {{ ($userCoffee->coffee->slug ?? old('name')) === $coffee->slug ? "selected='selected'" : "" }}>{{ $coffee->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="sugar" class="{{ $errors->has('sugar') ? 'invalid' : 'validate' }}">
                    @foreach($sugars as $number => $sugar)
                        <option value="{{ $number }}" {{ ($userCoffee->sugar ?? old('sugar')) === $number ? 'selected="selected"' : '' }}>{{ $sugar }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker{{ $errors->has('start_time') ? ' invalid' : ' validate' }}" name="start_time" value="{{ $userCoffee->start_time ?? old('start_time') }}" placeholder="From">
            </div>
        </div>

        <div class="col s6">
            <div class="input-field">
                <input type="text" class="timepicker{{ $errors->has('end_time') ? ' invalid' : ' validate' }}" name="end_time" value="{{ $userCoffee->end_time ?? old('end_time') }}" placeholder="To">
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="days[]" class="{{ $errors->has('days') ? 'invalid' : 'validate' }}" multiple>
                    @foreach($days as $key => $day)
                        <option value="{{ $key }}" {{ in_array($key, old('days', $userCoffee->days ?? [])) ? "selected='selected'" : "" }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('users.coffees.index', $user) }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
            <button class="btn waves-effect waves-light" type="submit">Save</button>
        </div>
    </div>

</form>
