@component('mail::message')

# Dear {{$customer_name}},

<h3>The online job you have requested in the 3D printing workshop on {{ $created_at->toDayDateTimeString() }} has
    been <b style="color: red">rejected</b> by Online Jobs Manager.</h3>

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

<h3>The reason for the rejection is the following:</h3>
<p style="color: red">{{ $message }}</p>

<p>If you need further assistance, please visit the workshop or contact the Online Jobs Manager via replying to this email</p>

@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk'])
    Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
