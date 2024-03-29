@component('mail::message')

# Hi

<h3>You have a new online request from {{$customer_name}}</h3>

<p>The details of a requested job are as follows:</p>
<div class="alert alert-info text-left">
    <p>
        Requested on: <b>{{ $created_at->toDayDateTimeString() }}</b><br>
        Requested by: <b>{{$customer_name}}</b><br>
        Requester id: <b>{{$customer_id}}</b><br>
        Requester email: <b>{{$customer_email}}</b><br>
        Module name or cost code: <b>{{$use_case}}</b><br>
    </p>
</div>


@component('mail::button', ['url' => 'https://dropoff.soton.ac.uk/pickup.php?claimID='.$claim_id.'&claimPasscode='.
    $claim_passcode.'&emailAddr=3dprint.soton%40gmail.com'])
    Download .stl files
@endcomponent

@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk'])
    Go to the website
@endcomponent

Kind Regards,<br>
{{ config('app.name') }}
@endcomponent
