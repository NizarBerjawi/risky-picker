@extends('layouts.base')

@section('content')
    <h3>Coffee<a href={{ route('coffees.create') }} class="btn-small waves-effect waves-light">Add</a></h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        <table class="col s12">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($coffees as $coffee)
                    <tr>
                        <td><a href="{{ route('coffees.show', $coffee) }}">{{ $coffee->name }}</a></td>
                        <td>{{ $coffee->description }}</td>
                        <td>
                            <a class="btn-floating btn-small grey lighten-4" href="{{ route('coffees.edit', $coffee) }}"><i class="tiny material-icons teal-text">edit</i></a>

                            <form action="{{ route('coffees.destroy', $coffee) }}" method="POST" style="display: inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>Oh No! There are no coffees available!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row center-align">
        {{ $coffees->links() }}
    </div>

@endsection
