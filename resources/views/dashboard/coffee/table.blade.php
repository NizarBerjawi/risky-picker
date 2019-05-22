<table>
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
    @forelse($coffees as $userCoffeee)
        <tr>
            <td>{{ $userCoffeee->coffee->name }}</td>
            <td>{{ $userCoffeee->sugar }}</td>
            <td>{{ $userCoffeee->start_time }} - {{ $userCoffeee->end_time }}</td>
            <td>{{ $userCoffeee->getFormattedDays() }}</td>
            <td>
                <a href="{{ route('dashboard.coffee.edit', $userCoffeee) }}"class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">edit</i></a>

                <form action="{{ route('dashboard.coffee.delete', $userCoffeee) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')

                    <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td>You don't have any coffees!</td>
        </tr>
    @endforelse
    </tbody>
</table>
