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
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('coffees.confirm-destroy', $coffee) }}"><i class="tiny material-icons teal-text">delete</i></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Oh No! There are no coffees available!</td>
            </tr>
        @endforelse
    </tbody>
</table>
