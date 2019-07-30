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

                    <form action="{{ route('dashboard.cups.delete', $cup) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@else
    <p>You don't have a coffee cup!</p>
@endif
