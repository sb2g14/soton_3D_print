@component('mail::message')

# Dear {{$customer_name}},

<h3>Your job requested on {{ $created_at->toDayDateTimeString() }} has been <b style="color: green;">successful</b>.</h3>

<p>The details of your request were as follows:</p>
<div class="alert alert-info text-left">
    <p>
        Requested on: <b>{{ $created_at->toDayDateTimeString() }}</b><br>
        Requested by: <b>{{$customer_name}}</b><br>
        Requester id: <b>{{$customer_id}}</b><br>
        Requester email: <b>{{$customer_email}}</b><br>
        Module name or cost code: <b>{{$use_case}}</b><br>
    </p>
</div>

<p>Please come to the workshop to collect your parts.</p>

@component('mail::button', ['url' => 'https://soton3dprint.clients.soton.ac.uk'])
    Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
