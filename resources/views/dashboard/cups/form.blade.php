<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method($method)

    <div class="row">
        <div class="file-field input-field col s12">
            <div class="btn">
                <span>Photo</span>
                <input type="file" name="cup_photo">
                @validation('cup_photo')
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Upload a photo of your cup">
            </div>
        </div>
    </div>

    @if (isset($cup) && $cup->hasImage())
        <div class="row">
            <div class="col s12 center-align">
                <img class="materialboxed responsive-img" src="{{ asset($cup->image_path) }}" >
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col s12 right-align">
            <a href="{{ route('dashboard.cups.index') }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text" type="submit">Cancel</a>
            <button class="btn waves-effect waves-light" type="submit">Save</button>
        </div>
    </div>
</form>
