@component('mail::message')

# Welcome!

This is a confirmation of successful registration. You are now able to use the workshop site. Please check the
Announcements section for the latest announcements and news about this application and the workshop.

@component('mail::button', ['url' => 'http://3dprint.clients.soton.ac.uk'])
Return to the workshop
@endcomponent

@component('mail::panel', ['url' => ''])
3D printing is awesome!
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
