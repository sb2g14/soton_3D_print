@extends('layouts.layout')
@section('content')
<div class="title m-b-md">
    Getting Paid
</div>
<div class="container well text-left">
    <div>
        Details on how to claim pay for time spent demonstrating are available at the <a href="https://www.southampton.ac.uk/hr/services/uniworkforce/index.page#introduction">UniWorkForce website</a>.

        Refer to the <a href="https://www.southampton.ac.uk/hr/services/uniworkforce/index.page#worker">&lsquo;Worker&rsquo; tab</a> for instructions on &lsquo;How to get paid&rsquo;.

        Please note: &lsquo;It is essential that you complete and submit your timesheet(s) for authorisation each month that you work, so that we can pay you the correct amount.&rsquo;

        Refer to the <a href="https://www.southampton.ac.uk/hr/services/uniworkforce/index.page#documents">&lsquo;Documents&rsquo; tab</a> for the UniworkForce Timesheet that needs to be completed when claiming.

        Use the following to complete the UnworkForce Timesheet:
        <ol>
            <li>Fill in your personal details.</li>
            <li><b>Pay reference number</b>: Refer to your Casual Worker Permit.</li>
            <li><b>Faculty</b>: <i>Engineering and the Environment</i></li>
            <li><b>Division</b>: <i>Central Faculty (FEE)</i></li>
            <li><b>Type of Work</b>:
                <ul>
                    <li>for PGRs: <i>Demonstrator</i></li>
                    <li>for UGs: <i>Student Demonstrator</i></li>
                </ul>
            </li>
            <li><b>Pay Rate</b>: <i>Demonstrator rate</i></li>
            <li><b>Supporting Comments</b>: Insert &lsquo;<i>3D Printing Service; Note: This is not a module but a workshop.</i>&rsquo; (or similar).
            <li>Fill in your hours worked for each date. @if($workinghours) You attended the following sessions: {{implode(", ",$workhours)}}.@endif You can also add preperation and training time to this.</li>
            <li><b>Name of hiring manager</b>: <i>Andrew Hamilton</i></li>
            <li>Fill in the <b>Job ID number</b> using the &lsquo;assignment ID number&rsquo; that you received via email upon appointment.</li>
            <li>Fill in your training attendance dates under the &lsquo;Demonstrator Training&rsquo; tab.
                <ol>
                    @php
                        if($member->SMT_date){
                            $smtdate = Carbon\Carbon::parse($member->SMT_date)->format('d/m/Y');
                        }else{
                            $smtdate = "--";
                        }
                        if($member->LWI_date){
                            $lwidate = Carbon\Carbon::parse($member->LWI_date)->format('d/m/Y');
                        }else{
                            $lwidate = "--";
                        }
                    @endphp
                    <li><b>Student ID</b>: <i>{{substr($member->student_id,1,8)}}</i></li>
                    <li><b>Member of staff you worked for</b>: <i>Andrew Hamilton</i></li>
                    <li><b>Faculty Orientation to Teaching & Demonstrating (OTD)</b>: Please see pgrtracker or gradbook</li>
                    <li><b>Specific Module Training by Module Lead</b>: <i>{{$smtdate}}</i></li>
                    <li><b>Relevant laboratory/workshop induction</b>: <i>{{$lwidate}}</i></li>
                    <li><b>Description</b>: <i>@if($member->SMT_date) Specific training on how to use the services management system has been attended. @endif  @if($member->LWI_date) Safety induction and training on operating 3D printers has been attended. @endif
                    </i></li>
                </ol>
            </li>
            <li>Save file using the filename specified on the lower right side of the hourly timesheet tab.</li>
        </ol> <br>
        At the end of each month, send your form to Andrew Hamilton (<a href="mailto:a.r.hamilton@soton.ac.uk">A.R.Hamilton@soton.ac.uk</a>) for approval.
    </div>
</div>
<div class="title m-b-md">
    Registering with UniWorkforce
</div>
<div class="container well text-left">
    <div>
        <ol>
            <li>Fill out the <a href="https://sotonac.sharepoint.com/teams/3DPrintingWorkshop/Shared%20Documents/Finance/Form+to+register+with+UniWorkforce.docx?d=w8888618265e04ec3bdc4acc7dcfd5bb8&csf=1&e=d4d9d9b47abd47bda9573dc15a1fc555">registration form</a>.
                <ul>
                    <li>The Online Staff Request ID is available from <a href="mailto:A.R.Hamilton@soton.ac.uk">Andrew Hamilton</a>.</li>
                    <li>You can skip the National Insurance number if you don't have one or don't know it. You can apply for a permanent National Insurance number with the city council.</li>
                </ul>
            </li>
            <li>Take the form and your original passport to the <a href="https://www.southampton.ac.uk/hr/services/uniworkforce/index.page">UniWorkforce</a> in the Reception of Building 26 on Highfield Campus. You may require further documents - please enquire with the <a href="https://www.southampton.ac.uk/hr/services/uniworkforce/index.page">UniWorkforce</a>.</li>
            <li>The staff there will take a copy of your passport and ask you to sign any relevant documents</li>
            <li>They will then give you a Casual Worker Permit (CWP).</li>
            <li>Once they completed registration (can take several days or weeks depending on how busy they are) you will receive an email with your Casual Work Permit Number (Pay Reference Number). Please enter this easily readable in your CWP.</li>
            <li>Make sure to save/print this email for future reference. Also note that you will need the Job-ID number (Assignment ID number) send in this email for your claims.</li>
            <li>Finally you need to show your CWP to Andrew Hamilton in Building 7/ Room 4045.</li>
        </ol>
    </div>
</div>
@endsection
