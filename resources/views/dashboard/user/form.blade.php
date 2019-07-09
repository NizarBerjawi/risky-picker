<form action={{ route('dashboard.profile.update', $user) }} method="POST">
    @csrf
    @method('PATCH')

    <div class="row">
        <div class="input-field col s12">
            <input id="first_name" type="text" class="{{ $errors->has('first_name') ? 'invalid' : 'validate' }}" name="first_name" value="{{ old('first_name', $user->first_name) }}" >
            <label for="first_name">{{ __('First Name') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="last_name" type="text" class="{{ $errors->has('last_name') ? 'invalid' : 'validate' }}" name="last_name" value="{{ old('last_name', $user->last_name) }}">
            <label for="last_name">{{ __('Last Name') }}</label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="email" type="email" name="email" value="{{ $user->email }}" disabled>
            <label for="email">Email</label>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <button class="btn waves-effect waves-light" type="submit">Save</button>
        </div>
    </div>
</form>
