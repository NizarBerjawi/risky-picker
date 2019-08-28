@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Schedules') }}</h5>

                <div class="right-align">
                    <a href={{ route('schedules.create') }} class="btn-small waves-effect waves-light">New Schedule</a>
                </div>

                @include('admin.schedules.table')
            </div>

            <div class="row center-align">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>
@endsection
