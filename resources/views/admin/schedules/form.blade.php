<form action="{{ $action ?? '' }}" method="POST">
    @if ($enabled ?? false)
        @csrf
        @method($method ?? 'GET')
    @endif

    <div class="row">
        <div class="col s12">
            <div class="input-field">
                <input type="text" class="timepicker {{ $errors->has('time') ? 'invalid' : 'validate' }}" name="time" value="{{ $schedule->time ?? old('time') }}" placeholder="Time" {{ ($enabled ?? false) ?: 'disabled' }}>
            </div>
        </div>

        <div class="col s12">
            <div class="input-field">
                <select name="days[]" class="{{ $errors->has('days') ? 'invalid' : 'validate' }}" multiple {{ ($enabled ?? false) ?: 'disabled' }}>
                    @foreach(days() as $key => $day)
                        <option value="{{ $key }}" {{ in_array($key, old('days', $schedule->days ?? [])) ? "selected='selected'" : "" }}>{{ $day }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('admin.schedules.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>Back</a>
            @if ($enabled ?? false)
            <button class="btn waves-effect waves-light" type="submit"><i class="material-icons left">save</i>Save</button>
            @endif
        </div>
    </div>
</form>
