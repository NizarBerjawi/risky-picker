@extends('layouts.base')

@section('content')
    <div class="section">
        @include('partials.validation')

        <div class="row">
            <form action="" method="POST">
                @csrf
                @method('PATCH')

                <p>Are you sure you want to remove this coffee from the current coffee run?</p>
                <p>This action is irreversable!</p>

                <a href="{{ route('index', $run) }}" class="btn blue-grey lighten-5 waves-effect waves-light black-text">Hell No!</a>
                <button class="btn waves-effect waves-light">Yes</button>
            </form>

        </div>
    </div>
@endsection
