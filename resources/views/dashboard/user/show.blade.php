<div class="card-panel">
    <div class="card-content">
        <h5 class="card-title">{{ __('Your details') }}</h5>

        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.profile.edit') }}>Edit</a>
        </div>

        @include('dashboard.user.form', [
            'enabled' => false,
            'action' => ''
        ])
    </div>
</div>
