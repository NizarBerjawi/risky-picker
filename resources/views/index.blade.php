@extends('layouts.base')

@section('content')
    <h3>Today's order</h3>

    @success
        @alert('success')
    @endsuccess

    @forelse($run->coffees as $userCoffee)
        <div class="col s12 m6">
            <div class="card">
                <div class="card-image">
                    <a href="{{ $userCoffee->user->cup ? $userCoffee->user->cup->image_path : '/dist/img/no-cup.png' }}" target="_blank">
                        <img class="" src="{{ $userCoffee->user->cup ? $userCoffee->user->cup->thumbnail_path : '/dist/img/no-cup-thumb.png' }}">
                    </a>

                    <a href="{{ $userCoffee->getAdhocUrl($run) }}" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">edit</i></a>
                </div>
                <div class="card-content">
                    <span class="card-title grey-text text-darken-4">{{ $userCoffee->user->full_name }}</span>
                    <p><strong>Coffee</strong>: {{ $userCoffee->coffee->name }}</p>
                    <p><strong>Sugars</strong>: {{ $userCoffee->sugar }}</p>
                </div>
            </div>

        </div>
    @empty
        <p>No coffee available</p>
    @endforelse
@endsection
