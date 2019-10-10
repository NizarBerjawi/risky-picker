<div class="fixed-action-btn">
    <!-- Modal Trigger -->
    <a href="#modal1" class="btn-floating btn-large red modal-trigger"><i class="large material-icons">local_cafe</i></a>
</div>

<!-- Modal Structure -->
<div id="modal1" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Today's Coffee</h4>
        <div class="row">
            <ul class="col s12 collection">
                @forelse($todaysCoffee as $coffee)
                    <li class="collection-item avatar">
                        <i class="medium material-icons teal-text circle">local_cafe</i>
                        <span class="title">{{ $coffee->type}}</span>
                        <p>{{ $coffee->getFormattedDays() }}<br>
                            {{ $coffee->start_time }} and {{ $coffee->end_time }}
                        </p>
                        <a href={{ route('dashboard.coffee.edit', $coffee) }} class="secondary-content">Edit</a>
                    </li>
                @empty
                    <li>No coffee scheduled for today!</li>
                @endforelse
            </ul>

        </div>
    </div>

    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">close</a>
    </div>
</div>
