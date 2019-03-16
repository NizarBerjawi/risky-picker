@extends('layouts.base')

@section('content')
    <h3>View Coffee</h3>

    <div class="row">
        @include('coffees.form', [
            'action' => route('coffees.update', compact('user', 'userCoffee')),
            'method' => 'put',
            'label' => 'Update',
            'disabled' => true,
        ])
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          var elems = document.querySelectorAll('select');
          var instances = M.FormSelect.init(elems, {});
        });

        document.addEventListener('DOMContentLoaded', function() {
           var elems = document.querySelectorAll('.timepicker');
           var instances = M.Timepicker.init(elems, {});
         });
    </script>
@endsection
