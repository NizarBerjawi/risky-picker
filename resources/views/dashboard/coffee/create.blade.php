@extends('layouts.dashboard')

@section('title', 'Coffees')

@section('content')
    @include('dashboard.coffee.form', [
        'action'  => isset($run)
            ? route('dashboard.adhoc.store', array_merge(compact('run'), request()->all()))
            : route('dashboard.coffee.store'),
        'method'  => 'POST',
        'enabled' => true,
        'adhoc'   => isset($run)
    ])
@endsection
