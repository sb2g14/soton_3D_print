@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        <h1>Demonstrators Rota</h1>
    </div>
    <div class="container well text-left">
        <iframe width="456" height="130" frameborder="0" scrolling="no" src="https://sotonac.sharepoint.com/teams/3DPrintingWorkshop/_layouts/15/WopiFrame.aspx?sourcedoc={c6b68a8a-05b8-4047-9916-c89b9587647f}&action=embedview&wdAllowInteractivity=False&Item='CurrentRota'!A1%3AC10&wdHideGridlines=True&wdInConfigurator=True" style="display: block; margin-left: auto; margin-right: auto"></iframe>
        <center>You need to sign in to view the current rota.</center>
    </div>
    <div class="title m-b-md">
        <h1>Demonstrator Workflow</h1>
    </div>
    <div class="container well text-left">
        <p>
        <ol>
            <li>When a student asks to print
                <ol type="a">
                    <li>discuss what they want to print and if this is the right service for them</li>
                    <li>find out what material they need</li>
                </ol>
            </li>
            <li>Give them a printer and make sure they know how to set it up
                <ol type="a">
                    <li>Make sure they have seen the student workflow document</li>
                </ol>
            </li>
            <li>When they are ready, go to their printer as soon as possible to approve their print:
                <ol type="a">
                    <li>Login to your account at <a href="https://3dprint.clients.soton.ac.uk/login">https://3dprint.clients.soton.ac.uk/</a></li>
                    <li>Select the <q><a href="https://3dprint.clients.soton.ac.uk/printingData/index">Pending Jobs</a></q> tab</li>
                    <li>Approve the submitted print</li>
                </ol>
            </li>
            <li>If a print has failed:
                <ol type="a">
                    <li>The print has to be stopped</li>
                    <li>Mark the print as failed</li>
                </ol>
            </li>
            <li>Once a print has finished, mark it as a success by pressing <q>Job Successful</q> button on the <q><a href="https://3dprint.clients.soton.ac.uk/printingData/approved">Approved Jobs/Printing</a></q> tab if print is still running in the system or through <q>Review Job</q> button in the <q><a href="https://3dprint.clients.soton.ac.uk/printingData/finished">Completed Jobs</a></q> tab.</li>
            <li>You can also report a failed job through <q>Review Job</q> button in the <q>Completed Jobs</q> tab after the print is finished.</li>
            <li>It is the student's responsibility to return all printing material once they are finished</li>
        </ol>
        </p>
        <p>
            Things to Note:
        <ul>
            <li>As a demonstrator, you need to ensure that students follow the workflow</li>
            <li>If you find any printer printing which is not in the list of approved jobs, then you have the authorisation and duty to stop the print</li>
            <li>If you find a student has taken a printer without permission from a demonstrator you have authorisation to ban them from using the service</li>
        </ul>
        </p>
    </div>
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
