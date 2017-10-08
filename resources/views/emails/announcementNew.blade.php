@component('mail::message')

# Dear {{ $name }}

{{ $message }}

@component('mail::button', ['url' => 'https://soton3dprint.clients.soton.ac.uk'])
3D printing workshop
@endcomponent

{{--@component('mail::panel', ['url' => ''])--}}
{{--3D printing is awesome!--}}
{{--@endcomponent--}}

Thanks,<br>
{{  $from }},
{{ config('app.name') }}
@endcomponent
