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
        @foreach($coffees as $userCoffee)
            <tr>
                <td><a href="{{ route('dashboard.coffee.show', $userCoffee) }}">{{ $userCoffee->type }}</a></td>
                <td>{{ $userCoffee->sugar }}</td>
                <td>{{ $userCoffee->start_time }} - {{ $userCoffee->end_time }}</td>
                <td>{{ $userCoffee->getFormattedDays() }}</td>
                <td>
                    <a href="{{ route('dashboard.coffee.edit', $userCoffee) }}"class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">edit</i></a>
                    <form action="{{ route('dashboard.coffee.delete', $userCoffee) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <button class="btn-floating btn-small grey lighten-4"><i class="tiny material-icons teal-text">delete</i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="center-align">
    {{ $coffees->links() }}
</div>
@else
    <p>You don't have any coffees!</p>
@endif
