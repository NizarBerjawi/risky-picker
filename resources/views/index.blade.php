@extends('layouts.base')

@section('content')
    <h3>Today's order</h3>

    @success
        @alert('success')
    @endsuccess

    @forelse($run->coffees as $coffee)
        <div class="col s12 m6">
            <div class="card">
                <div class="card-image">
                    <a href="{{ $coffee->user->cup ? $coffee->user->cup->image_path : '/dist/img/no-cup.png' }}" target="_blank">
                        <img class="" src="{{ $coffee->user->cup ? $coffee->user->cup->thumbnail_path : '/dist/img/no-cup-thumb.png' }}">
                    </a>

                    <a href="{{ $coffee->adhoc_url }}" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">edit</i></a>
                </div>
                <div class="card-content">
                    <span class="card-title grey-text text-darken-4">{{ $coffee->user->full_name }}</span>
                    <p><strong>Coffee</strong>: {{ $coffee->type }}</p>
                    <p><strong>Sugars</strong>: {{ $coffee->sugar }}</p>
                </div>
            </div>

        </div>
    @empty
        <p>No coffee available</p>
    @endforelse
@endsection
