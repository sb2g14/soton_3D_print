@component('mail::message')

Dear {{$customer_name}},

<h3>The online job you have requested from the 3D printing service on {{ $created_at->toDayDateTimeString() }} has
    been <b style="color: green">approved</b> by us.</h3>

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
<h3>The estimated printing time and price of the job are:</h3>
<div class="alert alert-info text-left">
    <p>
        Duration: <b>{{ $total_duration }}</b><br>
        Price: <b>£{{$total_price}}</b><br>
    </p>
</div>

<p style="color: red">The print will not start until you reply to this email expressing your consent to proceed with
printing your request.</p>

<p>If you need further assistance, please visit the workshop or contact one of our Online Jobs Manager by replying to this email.</p>

@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk'])
Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
