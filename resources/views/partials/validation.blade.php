@if(session()->has('success'))
    @alert('success')
@endif

@if(session()->has('errors'))
    @alert('errors')
@endif
