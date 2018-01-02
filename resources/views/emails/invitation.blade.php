@component('mail::message')

# Dear {{ $name }}

You are warmly invited to join 3D Printing Workshop team!

Please click the button and register with our website
@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk/register'])
3D printing workshop
@endcomponent

{{--@component('mail::panel', ['url' => ''])--}}
{{--3D printing is awesome!--}}
{{--@endcomponent--}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
