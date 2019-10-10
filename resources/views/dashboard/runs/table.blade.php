@if (isset($runs) && $runs->isNotEmpty())
    <table class="responsive-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>User</th>
                <th>Total Coffees
                <th>Volunteers</th>
                @if (request()->user()->isAdmin())
                    <th>Actions</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @forelse($runs as $run)
                <tr>
                    <td><a href="{{ route('dashboard.runs.show', $run) }}">{{ $run->created_at->format('h:i A') }}</a></td>
                    <td>{{ $run->user->full_name }}</td>
                    <td>{{ $run->userCoffees->count() }}</td>
                    <td>
                        @if ($run->notExpired() && request()->user()->is($run->user))
                            @if (!$run->hasVolunteer())
                                <form action={{ route('dashboard.runs.busy', $run) }} method="POST">
                                    @csrf
                                    <button type="submit" class="waves-effect waves-light btn-small{{ $run->volunteerRequested() ? ' disabled' : ''}}">Busy</button>
                                </form>

                                @if ($run->volunteerRequested())
                                    <small>Volunteer requested...</small>
                                @endif
                            @endif

                            @if ($run->hasVolunteer() && !request()->user()->hasVolunteeredFor($run))
                                <form action={{ route('dashboard.runs.volunteer', $run) }} method="POST">
                                    @csrf
                                    <button type="submit" class="waves-effect waves-light btn-small">Volunteer</button>
                                </form>
                            @endif

                            @if ($run->hasVolunteer())
                                <span class="badge"><small>{{ $run->volunteer->full_name }}</small></span>
                            @endif
                        @endif

                        @if ($run->notExpired() && request()->user()->isNot($run->user))
                            @if (!request()->user()->hasVolunteeredFor($run))
                                <form action={{ route('dashboard.runs.volunteer', $run) }} method="POST">
                                    @csrf
                                    <button type="submit" class="waves-effect waves-light btn-small">Volunteer</button>
                                </form>
                            @endif

                            @if ($run->hasVolunteer())
                                <span class="badge"><small>{{ $run->volunteer->full_name }}</small></span>
                            @endif
                        @endif
                    </td>
                    <td>
                        @can('pick', $run)
                            <form action={{ route('dashboard.runs.update', $run) }} method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="waves-effect waves-light btn-small tooltipped" data-position="top" data-tooltip="Randomly select a new user to do this run" name="action" value="pick"><i class="tiny material-icons">refresh</i></button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row center-align">
        {{ $runs->links() }}
    </div>
@else
    <p>There are no coffee runs coming up!</p>
@endif
