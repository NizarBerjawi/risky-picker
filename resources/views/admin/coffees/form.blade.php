<form action={{ $action ?? '' }} method="post">
    @if ($enabled ?? false)
        @csrf
        @method($method ?? 'GET')
    @endif

    <div class="row">
        <div class="input-field col s12">
            <input id="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" type="text" name="name" value="{{ $coffee->name ?? old('name') }}" {{ ($enabled ?? false) ?: 'disabled' }} >
            <label for="name">{{ __('Name') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <textarea id="description" class="materialize-textarea {{ $errors->has('description') ? 'invalid' : 'validate' }}" type="text" name="description" value="{{ $coffee->description ?? old('description') }}" {{ ($enabled ?? false) ?: 'disabled' }}>{{ $coffee->description ?? old('description') }}</textarea>
            <label for="description">{{ __('Description') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('admin.coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>{{ __('Back') }}</a>
            @if ($enabled ?? false)
                <button class="btn waves-effect waves-light" type="submit"><i class="material-icons left">save</i>{{ __('Save') }}</button>
            @endif
        </div>
    </div>
</form>
