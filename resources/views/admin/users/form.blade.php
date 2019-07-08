<form action={{ $action }} method="post" enctype="multipart/form-data">
    @csrf
    @method($method)

    <div class="row">
        <div class="input-field col s12">
            <input id="first_name" class="{{ $errors->has('first_name') ? 'invalid' : 'validate' }}" type="text" name="first_name" value="{{ $user->first_name ?? old('first_name') }}">
            <label for="first_name">First Name</label>
            @validation('first_name')
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="last_name" class="{{ $errors->has('last_name') ? 'invalid' : 'validate' }}" type="text" name="last_name" value="{{ $user->last_name ?? old('last_name') }}">
            <label for="last_name">Last Name</label>
            @validation('last_name')
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="email" type="text" name="email" value="{{ $user->email }}" disabled>
            <label for="email">Email</label>
        </div>
    </div>

    <div class="row">
        <div class="switch col">
            <p>Does this user think they're too good to do a coffee run?</p>
            <label>
                No
                <input type="checkbox" name="is_vip" value="yes">
                <span class="lever"></span>
                Yes
            </label>
        </div>
    </div>

    <div class="row">
        <div class="switch col">
            <p>Is this user an admin?</p>
            <label>
                No
                <input type="checkbox" name="is_admin" value="yes">
                <span class="lever"></span>
                Yes
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            <a href={{ route('users.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
            <button class="btn waves-effect waves-light" type="submit">Save</button>
        </div>
    </div>
</form>
