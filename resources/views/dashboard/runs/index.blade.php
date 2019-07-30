<div class="card-panel">
    <div class="card-content">
        <h5 class="card-title">{{ __('Runs') }}</h5>

        @include('dashboard.runs.table')

        @isset($countdown)
            <div class="right-align"><small>(Next run is {{ $countdown }})</small></div>
        @endisset
    </div>
</div>
