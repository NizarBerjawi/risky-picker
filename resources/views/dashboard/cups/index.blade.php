<div class="card-panel">
    <div class="card-content">
        <h5 class="card-title">{{ __('Your cup') }}</h5>

        @if (request()->user()->doesntHaveCup())
            <div class="right-align">
                <a class="waves-effect waves-light btn-small" href={{ route('dashboard.cups.create') }}>Add</a>
            </div>
        @endif

        @include('dashboard.cups.table')
    </div>
</div>
