@extends('layouts.base')

@section('content')
    <h3>Users
        <a href={{ route('users.create') }} class="btn-small waves-effect waves-light">Add</a>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><a href="{{ route('users.show', $user) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a class="btn-floating btn-small grey lighten-4" href="{{ route('coffees.index', $user) }}"><i class="tiny material-icons teal-text">local_cafe</i></a>

                            <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.edit', $user) }}"><i class="tiny material-icons teal-text">edit</i></a>

                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No lunch for you today!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row center-align">
        {{ $users->links() }}
    </div>
@endsection
