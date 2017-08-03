@component('mail::message')

# Welcome!

Thank you for registering!

@component('mail::button', ['url' => 'http://3dprint.clients.soton.ac.uk'])
Continue browsing
@endcomponent

@component('mail::panel', ['url' => ''])
3D printing is awesome!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
