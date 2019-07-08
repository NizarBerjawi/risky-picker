<table class="responsive-table">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            {{-- <th>Pickable</th> --}}
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>

                {{-- <td>
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        @if ($user->isVIP())
                            <button class="waves-effect waves-light btn-small" >No</button>
                        @else
                            <button class="waves-effect grey waves-light btn-small">Yes</button>
                        @endif
                    </form>
                </td> --}}
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.index', $user) }}"><i class="tiny material-icons teal-text">local_cafe</i></a>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.edit', $user) }}"><i class="tiny material-icons teal-text">edit</i></a>
                    @if (!$user->is(request()->user()))
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                    </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td>No one wants coffee!</td>
            </tr>
        @endforelse
    </tbody>
</table>
