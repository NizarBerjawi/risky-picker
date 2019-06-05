@extends('layouts.base')

@section('content')
    <h3>Today's order</h3>

    @forelse($users as $user)
      <div class="col s12 m6">
        <div class="card horizontal">
          <div class="card-image">
            <img src="{{ ($user->cup) ? $user->cup->file_path : 'https://lorempixel.com/100/190/nature/6' }}">
          </div>
          <div class="card-stacked">
            <div class="card-content">
              <h6>{{ $user->full_name }}</h6>
              <p>{{ $user->nextCoffee->type }}</p>
              <p>{{ $user->nextCoffee->sugar }} Sugars</p>
            </div>
            <div class="card-action">
              <a href="{{ $user->nextCoffee->adhoc_url }}">Change my Coffee</a>
            </div>
          </div>
        </div>
      </div>
    @empty
      <p>No coffee available</p>
    @endforelse
@endsection
