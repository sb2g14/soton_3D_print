@component('mail::message')
# Dear Demonstrator,<br/>
Please find the rota for <b>{{ Carbon\Carbon::parse($date)->format('D, dS \\of M Y') }}</b> as below.<br/>
<table>
    <tbody>
    @foreach($sessions as $s)
        @php
            $starttime = Carbon\Carbon::parse($s['start_date'])->format('G:i');
            $endtime = Carbon\Carbon::parse($s['end_date'])->format('G:i');
        @endphp
        <tr>
            <td class="text-right">
                {{$starttime}} &ndash; {{$endtime}} &nbsp;
            </td>
            <td class="text-left">
                @php
                $sess = App\Sessions::findOrFail($s['id']);
                @endphp
                @if($sess->staff()->count()>0)
                    @php
                        $dems = [];
                        foreach($sess->staff as $dem){
                            $dems[] = $dem->first_name.' '.$dem->last_name;
                        }
                    @endphp
                    {!!implode(", ",$dems)!!}
                @else
                    (to be decided)
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table><br/>

{{ $message }}

@component('mail::button', ['url' => 'https://3dprint.clients.soton.ac.uk/rota/availability'])
    Indicate Availability
@endcomponent
Kind regards,<br/>
{{ config('app.name') }}
@endcomponent
