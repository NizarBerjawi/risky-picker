<table>
    <thead>
        <tr>
            <th>Cup</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($cups as $cup)
        <tr>
            <td><img src="{{ asset($cup->file_path) }}" width="100"/></td>
            <td>{{ $cup->created_at }}</td>
            <td>{{ $cup->updated_at}}</td>
            <td>
                <a href="{{ route('dashboard.cups.edit', $cup) }}"class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">edit</i></a>

                <form action="{{ route('dashboard.cups.delete', $cup) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td>You don't have any cups!</td>
        </tr>
    @endforelse
    </tbody>
</table>
