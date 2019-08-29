@extends('layouts.base')

@section('content')
    <div class="card-panel">
        <div class="card-content">
            <h5 class="card-title">{{ __('Statistics') }}</h5>
            @if ($users->isNotEmpty())
                <table class="responsive-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total this month</th>
                            <th>Total since the beginning of time</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            @php
                                $monthlyTotal = array_get($monthlyData->where('user_id', $user->id)->first(), 'total', 0);
                            @endphp
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $monthlyTotal }}</td>
                                <td>{{ $user->coffee_runs_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="center-align">
                    {{ $users->links() }}
                </div>
            @else
                <p>There are no statistics yet!</p>
            @endif
        </div>
    </div>
@endsection
