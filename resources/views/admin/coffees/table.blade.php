<table class="col s12 responsive-table">
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
                <td>{{ $coffee->name }}</td>
                <td>{{ $coffee->description }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('coffees.edit', $coffee) }}"><i class="tiny material-icons teal-text">edit</i></a>

                    <form action="{{ route('coffees.destroy', $coffee) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Oh No! There are no coffees available!</td>
            </tr>
        @endforelse
    </tbody>
</table>
