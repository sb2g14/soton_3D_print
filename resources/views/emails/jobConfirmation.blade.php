@component('mail::message')

# Hi

@component('mail::button', ['url' => 'https://soton3dprint.clients.soton.ac.uk'])
    Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
