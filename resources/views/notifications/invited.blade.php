@component('mail::message')
# Hi there!

You've been invited to join the Coffee Picker.

@component('mail::button', ['url' => $url])
Coffee... Now!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
