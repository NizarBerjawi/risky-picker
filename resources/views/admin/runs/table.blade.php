<table class="col s12">
    <thead>
        <tr>
            <th>User</th>
            <th>Total Coffees
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        @forelse($runs as $run)
            <tr>
                <td>{{ $run->user->full_name }}</td>
                <td>{{ $run->coffees->count() }}</td>
            </tr>
        @empty
            <tr>
                <td>No coffee runs yet!</td>
            </tr>
        @endforelse
    </tbody>
</table>
