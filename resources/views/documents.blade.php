@extends('layouts.layout')
@section('content')
<div class="title m-b-md">
    Documents
</div>
<div class="container well text-left">
    <h1>Useful downloads</h1>
    <ul class="lsn">
        <li><a href={{ asset('files/UP_Manual.pdf') }}>UP Manual</a></li>
        <li><a href={{ asset('files/UPBOX_Manual.pdf') }}>UP BOX Manual</a></li>
        <li><a href={{ asset('files/LoanForm_Soton_3D_Printing.docx') }}>Request a Loan Form</a></li>
        {{--<li><a href={{ asset('files/Online_3D_Printing_Service_v2.pdf') }}>Guidance how to use 3D hubs</a></li>--}}
    </ul>
</div>
@endsection
