@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Update this schedule') }}</h5>

                <div class="row">
                    @include('admin.schedules.form', [
                        'action'  => route('schedules.update', $schedule),
                        'method'  => 'PUT',
                        'enabled' => true,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
