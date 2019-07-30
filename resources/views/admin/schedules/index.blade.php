@extends('layouts.base')

@section('content')
    <div class="section">
        <div class="row">
            <div class="right-align">
                <a href={{ route('schedules.create') }} class="btn-small waves-effect waves-light">New Schedule</a>
            </div>

            @include('admin.schedules.table')
        </div>
    </div>
@endsection
