@extends('layouts.dashboard')

@section('runs')
    @include('dashboard.runs.index')
@endsection

@section('user')
    @include('dashboard.user.show')
@endsection

@section('coffees')
    @include('dashboard.coffee.index')
@endsection

@section('cups')
    @include('dashboard.cups.index')
@endsection
