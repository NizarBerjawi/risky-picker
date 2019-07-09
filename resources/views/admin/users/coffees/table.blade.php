<table class="col s12 responsive-table">
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
                <td>{{ $coffee->type }}</td>
                <td>{{ $coffee->sugar }}</td>
                <td>{{ $coffee->start_time }} - {{ $coffee->end_time }}</td>
                <td>{{ $coffee->getFormattedDays() }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.edit', ['user' => $user, 'coffee' => $coffee->id]) }}"><i class="tiny material-icons teal-text">edit</i></a>

                    <form action="{{ route('users.coffees.destroy', ['user' => $user, 'coffee' => $coffee->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No coffee for this user!</td>
            </tr>
        @endforelse
    </tbody>
</table>
