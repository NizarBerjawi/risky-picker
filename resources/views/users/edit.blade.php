@extends('layouts.base')

@section('content')
    <h3>Update User</h3>

    @if(session()->has('success'))
        @include('partials.success', [
            'message' => session('success')->first()
        ])
    @endif

    <div class="row">
        @include('users.form', [
            'action' => route('users.update', $user),
            'method' => 'put',
            'label' => 'Update',
        ])
    </div>
@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var elems = document.querySelectorAll('.materialboxed');
      var instances = M.Materialbox.init(elems, options);
    });
  </script>
@endsection
