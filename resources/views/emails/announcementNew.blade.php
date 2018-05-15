@component('mail::message')
# Dear {{ $member }},<br/>

{{ $message }}

@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk'])
3D printing workshop
@endcomponent

Thanks,<br>
{{ $from }},
{{ config('app.name') }}
@endcomponent
