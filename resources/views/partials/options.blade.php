<div class="fixed-action-btn">
    @onadmin
    <a class="btn-floating btn-large waves-effect waves-light" href="{{ route('dashboard.profile.edit') }}">
        <i class="material-icons">home</i>
    </a>
    @endonadmin

    @ondashboard
    <!-- Modal Trigger -->
    <a href="#modal1" class="btn-floating btn-large red modal-trigger"><i class="large material-icons">local_cafe</i></a>

    @if(Auth::user()->isAdmin())
        <a class="btn-floating btn-large waves-effect waves-light" href="{{ route('picker') }}">
            <i class="material-icons">dashboard</i>
        </a>
    @endif
    @endondashboard
</div>

@ondashboard
<!-- Modal Structure -->
<div id="modal1" class="modal bottom-sheet">
    <div class="modal-content">
        <h4>Order Details</h4>

        <div class="row">

          <ul class="col s12 m6 offset-m3 collection">
              @foreach(Auth::user()->userCoffees as $coffee)
              <li class="collection-item avatar">
                  <img src="images/yuna.jpg" alt="" class="circle">
                  <span class="title">{{ $coffee->type}}</span>
                  <p>{{ $coffee->getFormattedDays() }}<br>
                      {{ $coffee->start_time }} and {{ $coffee->end_time }}
                  </p>
                  <a href={{ route('dashboard.coffee.edit', $coffee) }} class="secondary-content">Edit</a>
              </li>
              @endforeach
          </ul>

        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
    </div>
</div>
@endondashboard
