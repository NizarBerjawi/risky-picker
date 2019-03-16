@extends('layouts.base')

@section('content')
    <h3>Select Coffee</h3>

    <div class="row">
        @include('coffees.form', [
            'action' => route('coffees.store', $user),
            'method' => 'post',
            'label' => 'Add',
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
