<form action="{{ $action ?? '' }}" method="POST">
    @if ($enabled ?? false)
        @csrf
        @method($method ?? 'GET')
    @endif

    <div class="row">
        <div class="input-field col s12">
            <label>{{ __('First Name') }}</label>
            <input type="text" class="{{ $errors->has('first_name') ? 'invalid' : 'validate' }}" name="first_name" value="{{ old('first_name', $user->first_name) }}"  {{ ($enabled ?? false) ?: 'disabled' }}>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <label>{{ __('Last Name') }}</label>
            <input type="text" class="{{ $errors->has('last_name') ? 'invalid' : 'validate' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}" {{ ($enabled ?? false) ?: 'disabled' }}>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input type="email" name="email" value="{{ $user->email }}" disabled>
            <label>Email</label>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            @if ($enabled ?? false)
                <a href="{{ route('dashboard.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">Back</a>
                <button class="btn waves-effect waves-light" type="submit">Save</button>
            @endif
        </div>
    </div>
</form>
