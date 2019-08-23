@if($cup)
    <table class="responsive-table">
        <thead>
            <tr>
                <th>Cup</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><a href="{{ route('dashboard.cups.show', $cup) }}"><img src="{{ asset($cup->thumbnail_path) }}" width="100"/></a></td>
                <td>
                    <a href="{{ route('dashboard.cups.edit', $cup) }}" class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">edit</i></a>
                    <a href="{{ route('dashboard.cups.confirm-delete', $cup) }}" class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></a>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p>You don't have a coffee cup!</p>
@endif
