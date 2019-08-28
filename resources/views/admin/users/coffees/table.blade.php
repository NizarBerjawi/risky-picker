@if ($coffees->isNotEmpty())
<table class="responsive-table">
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
        @foreach($coffees as $coffee)
            <tr>
                <td>{{ $coffee->type }}</td>
                <td>{{ $coffee->sugar }}</td>
                <td>{{ $coffee->start_time }} - {{ $coffee->end_time }}</td>
                <td>{{ $coffee->getFormattedDays() }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.edit', ['user' => $user, 'coffee' => $coffee->id]) }}"><i class="tiny material-icons teal-text">edit</i></a>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('users.coffees.confirm-destroy', ['user' => $user, 'coffee' => $coffee->id]) }}"><i class="tiny material-icons teal-text">delete</i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <p>No coffee for this user!</p>
@endif
