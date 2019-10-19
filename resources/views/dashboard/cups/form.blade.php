<form action="{{ $action ?? '' }}" method="POST" enctype="multipart/form-data">
    @if ($enabled ?? false)
        @csrf
        @method($method ?? 'GET')
    @endif

    @if ($enabled ?? false)
        <div class="row">
            <div class="file-field input-field col s12">
                <div class="btn">
                    <span><i class="material-icons left">folder_open</i>Browse</span>
                    <input type="file" name="cup_photo">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Upload a photo of your cup">
                </div>
            </div>
        </div>
    @endif

    @if (isset($cup) && $cup->hasImage())
        <div class="row">
            <div class="col s12 center-align">
                <img class="materialboxed responsive-img" src="{{ asset($cup->image_path) }}" >
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col s12 right-align">
            <a href="{{ route('dashboard.cups.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text"><i class="material-icons left">keyboard_backspace</i>Back</a>
            @if ($enabled ?? false)
                <button class="btn waves-effect waves-light" type="submit"><i class="material-icons left">save</i>Save</button>
            @endif
        </div>
    </div>
</form>
