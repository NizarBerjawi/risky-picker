<form action={{ empty($disabled) ? $action : '' }} method="post">
    {{ csrf_field() }}
    {{ empty($disabled) ? method_field($method) : '' }}

    <div class="row">
        <div class="input-field col s12">
            <input id="name" class="{{ $errors->has('name') ? 'invalid' : 'validate' }}" type="text" name="name" value="{{ $coffee->name ?? old('name') }}" {{ !empty($disabled) ? 'disabled' : ''}}>
            <label for="name">Name</label>
            @if(empty($disabled) && $errors->has('name'))
                <span class="helper-text" data-error="{{ $errors->first('name') }}"></span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
            <textarea id="description" class="materialize-textarea {{ $errors->has('description') ? 'invalid' : 'validate' }}" type="text" name="description" value="{{ $coffee->description ?? old('description') }}" {{ !empty($disabled) ? 'disabled' : ''}}>{{ $coffee->description ?? old('description') }}</textarea>
            <label for="description">Description</label>
            @if(empty($disabled) && $errors->has('description'))
                <span class="helper-text" data-error="{{ $errors->first('description') }}"></span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col s12 right-align">
            @if(empty($disabled))
                <a href={{ route('coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Cancel</a>
                <button class="btn waves-effect waves-light" type="submit">Save
                    <i class="material-icons right">send</i>
                </button>
            @else
                <a href={{ route('coffees.index') }} class="btn blue-grey lighten-5 waves-effect waves-light black-text">Back</a>
                <a href={{ route('coffees.edit', $coffee) }} class="btn waves-effect waves-light">Edit</a>
            @endif
        </div>
    </div>
</form>
