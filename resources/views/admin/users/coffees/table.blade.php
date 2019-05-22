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
                <td>{{ $coffee->name }}</td>
                <td>{{ $coffee->pivot->sugar }}</td>
                <td>{{ $coffee->pivot->start_time }} - {{ $coffee->pivot->end_time }}</td>
                <td>{{ $coffee->pivot->getFormattedDays() }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.edit', ['user' => $user, 'coffee' => $coffee->pivot->id]) }}"><i class="tiny material-icons teal-text">edit</i></a>

                    <form action="{{ route('users.coffees.destroy', ['user' => $user, 'coffee' => $coffee->pivot->id]) }}" method="POST" style="display: inline;">
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
