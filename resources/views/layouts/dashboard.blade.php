
@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ webpack('app', 'css') }}" type="text/css">
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ webpack('app') }}"></script>
@endsection
