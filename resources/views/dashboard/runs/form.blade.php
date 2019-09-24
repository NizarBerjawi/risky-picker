<form action={{ $action }} method="post">
    @csrf
    @method($method)

    <div class="row">
        <div class="input-field col s12">
            <input id="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" type="text" name="name" value="{{ $coffee->name ?? old('name') }}" >
            <label for="name">{{ __('Name') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <textarea id="description" class="materialize-textarea {{ $errors->has('description') ? 'invalid' : 'validate' }}" type="text" name="description" value="{{ $coffee->description ?? old('description') }}">{{ $coffee->description ?? old('description') }}</textarea>
            <label for="description">{{ __('Description') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">{{ __('Cancel') }}</a>
            <button class="btn waves-effect waves-light" type="submit">{{ __('Save') }}</button>
        </div>
    </div>
</form>
