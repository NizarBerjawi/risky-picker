@if ($coffees->isNotEmpty())

<table class="responsive-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        @foreach($coffees as $coffee)
            <tr>
                <td><a href="{{ route('admin.coffees.show', $coffee) }}">{{ $coffee->name }}</a></td>
                <td>{{ $coffee->description }}</td>
                <td>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('admin.coffees.edit', $coffee) }}"><i class="tiny material-icons teal-text">edit</i></a>
                    <a class="btn-floating btn-small grey lighten-4" href="{{ route('admin.coffees.confirm-destroy', $coffee) }}"><i class="tiny material-icons teal-text">delete</i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row center-align">
    {{ $coffees->links() }}
</div>
@else
    <p>Oh No! There are no coffees available!</p>
@endif
