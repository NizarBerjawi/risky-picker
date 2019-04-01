@extends('layouts.base')

@section('content')
    <h3>Coffees
        <a href={{ route('users.coffees.create', $user) }} class="btn-small waves-effect waves-light">Add</a>
    </h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        <table class="col s12">
            <thead>
                <tr>
                    <th>Coffee</th>
                    <th>Sugar</th>
                    <th>Between</th>
                    <th>On</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($coffees as $coffee)
                    <tr>
                        <td><a href="{{ route('users.coffees.show', ['user' => $user, 'coffee' => $coffee->pivot->id]) }}">{{ $coffee->name }}</a></td>
                        <td>{{ $coffee->pivot->sugar }}</td>
                        <td>{{ $coffee->pivot->start_time }} - {{ $coffee->pivot->end_time }}</td>
                        <td>{{ $coffee->pivot->getFormattedDays() }}</td>
                        <td>
                            <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.edit', ['user' => $user, 'coffee' => $coffee->pivot->id]) }}"><i class="tiny material-icons teal-text">edit</i></a>

                            <form action="{{ route('users.coffees.destroy', ['user' => $user, 'coffee' => $coffee->pivot->id]) }}" method="POST" style="display: inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No coffee for you today!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row center-align">
        {{ $coffees->links() }}
    </div>
@endsection
