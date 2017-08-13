@extends('layouts.layout')
@section('content')
<div class="title m-b-md">
    Order online
</div>
<div class="container well text-left">
    <div>
        This guide is for anyone who wish to 3D print parts for project without going to the workshop, this service will usually take 1 to 2 working days and completed print can be pick up in B13 workshop.
        You will NOT be charged with any cash! Instead you need to have a valid budget code. This means that the cost of your print will directly deduct from your project budget.
        If you’re not printing for university’s project, you can use 15% discount code “SOTONUNI” to order your print. This discount code is also valid for other Hub.
    </div>
</div>
<div class="title m-b-md">
    How to do it
</div>
<div class="container well text-left">
    <div>
        Visit <a href="https://www.3dhubs.com/service/254134">3Dhubs</a> and click "GET A QUOTE FROM THIS HUB". The follow the steps:<br>
        <ol>
            <li>Upload your model (make sure it is in STL format).</li>
            <li>Select Material (ABS, PLA), COLOR and Resolution (e.g. 200Micron = 0.2mm per layer). Then write down Your Name, Student ID, Project Number (e.g. FEEG2001-UAV05, IP02, GDP27), Cost Code, Print comment.</li>
            <li>Enter your email and click "Submit Request"</li>
        </ol><br>
        Once your order is accepted, you will be in touch with us shortly and you will receive a 100% discount voucher code for this print. Apply this code in the “Add voucher” section to complete the online payment process. (The payment will be made by deduction from your project budget, not from your bank)
        Once the print is completed, our demonstrator will contact you via email for pick up.<br>

        For reference purposes please download the <a href={{ asset('files/Online_3D_Printing_Service_v2.pdf') }}>PDF Version</a>.
    </div>
</div>
@endsection
