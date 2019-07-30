<div class="card-panel">
    <div class="card-content">
        <h5 class="card-title">{{ __('Your coffees') }}</h5>

        <div class="right-align">
            <a class="waves-effect waves-light btn-small" href={{ route('dashboard.coffee.create') }}>Add</a>
        </div>

        @include('dashboard.coffee.table')
    </div>
</div>
