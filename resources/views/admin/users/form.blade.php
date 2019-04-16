<form action={{ empty($disabled) ? $action : '' }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    {{ empty($disabled) ? method_field($method) : '' }}

    <div class="row">
        <div class="input-field col s12">
            <input id="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" type="text" name="name" value="{{ $user->name ?? old('name') }}" {{ !empty($disabled) ? 'disabled' : ''}}>
            <label for="name">Name</label>
            @if(empty($disabled) && $errors->has('name'))
                <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <input id="email" class="{{ $errors->has('email') ? 'invalid' : 'validate' }}" type="text" name="email" value="{{ $user->email ?? old('email') }}" {{ !empty($disabled) ? 'disabled' : ''}}>
            <label for="email">Email</label>
            @if(empty($disabled) && $errors->has('email'))
                <span class="helper-text" data-error="{{ $errors->first('email') }}"></span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="file-field input-field col s12">
          <div class="btn">
            <span>Photo</span>
            <input type="file" name="cup_photo">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text" placeholder="Upload a photo of your cup">
          </div>
        </div>
    </div>

    @if (isset($user) && $user->hasCup() && $user->cup->hasImage())
    <div class="row">
        <div class="col s12 center-align">
          <img class="materialboxed" width="250" src="{{ asset($user->cup->file_path) }}" style="margin: auto;">
          @if (empty($disabled))
          <button type="submit" name="delete_cup" value="{{ $user->cup->id }}" class="btn-floating btn-small"><i class="tiny material-icons">delete</i></button>
          @endif
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col s12 right-align">
            @if(empty($disabled))
                <a href={{ route('users.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
                <button class="btn waves-effect waves-light" type="submit">Save
                    <i class="material-icons right">send</i>
                </button>
            @else
                <a href={{ route('users.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Back</a>
                <a href={{ route('users.edit', $user) }} class="btn waves-effect waves-light">Edit</a>
            @endif
        </div>
    </div>
</form>
