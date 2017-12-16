@component('mail::message')

# Dear {{$customer_name}},

<h3>Unfortunately we were <b style="color: red">unable</b> to fulfill your job requested on
    {{ $created_at->toDayDateTimeString() }}.</h3>

<h3>The reason for failing to fulfil your request is the following:</h3>
<p style="color: red">{{ $message }}</p>

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

<p>Please, contact our online request manager by replying to this email and find out what needs to be done to
successfully resubmit the request.</p>

@component('mail::button', ['url' => 'https://soton3dprint.clients.soton.ac.uk'])
    Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
