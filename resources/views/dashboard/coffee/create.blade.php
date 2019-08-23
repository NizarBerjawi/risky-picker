@extends('layouts.base')

@section('content')
    <div class="col s12 m8 offset-m2">
        <div class="card-panel">
            <div class="card-content">
                <h5 class="card-title">{{ __('Add a Coffee') }}</h5>

                @include('dashboard.coffee.form', [
                    'action'  => isset($run)
                        ? route('dashboard.adhoc.store', array_merge(compact('run'), request()->all()))
                        : route('dashboard.coffee.store'),
                    'method'  => 'POST',
                    'enabled' => true,
                    'adhoc'   => isset($run)
                ])
            </div>
        </div>
    </div>
@endsection
