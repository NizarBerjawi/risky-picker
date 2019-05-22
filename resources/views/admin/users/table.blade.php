<table class="col s12">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.index', $user) }}"><i class="tiny material-icons teal-text">local_cafe</i></a>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.edit', $user) }}"><i class="tiny material-icons teal-text">edit</i></a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

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
