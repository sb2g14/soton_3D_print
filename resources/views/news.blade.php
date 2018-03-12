@extends('layouts.layout')
@section('content')
    <div class="title m-b-md">
        Workshop History
    </div>
    <ul class="lsn container printer-details">
    @php
        $entries = [];
        $entry = [];
        $entry['icon'] = "flag";
        $entry['Time'] = "Early 2014";
        $entry['Text'] = "The Workshop was founded by Shoufeng Yang, with the aim to give students the chance to get to know 3D printing and experience the possibilities of fast prototyping.";
        $entries[] = $entry;
        $entry['icon'] = "edit";
        $entry['Time'] = "2014";
        $entry['Text'] = "The workshop operates with only a few printers. Initially Up! and soon after Up Plus 2 printers were purchased. Thanks to the management of Dani Newman, students could use the workshop to there liking, but had to pay a small fee to allow for material cost to be covered.";
        $entries[] = $entry;
        $entry['Time'] = "Late 2014";
        $entry['Text'] = "The workshops popularity increases and it now used by several modules to enable students to create items in their design projects.";
        $entries[] = $entry;
        $entry['icon'] = "cogs";
        $entry['Time'] = "Spring 2015";
        $entry['Text'] = "To simplify the demonstrating and printing process, two changes are made: Prints are now managed in a consistent spreadsheet and they are free of charge. This increased the usage of the workshop since more students start to use the workshop for printing for their own use.";
        $entries[] = $entry;
        $entry['icon'] = "archive";
        $entry['Time'] = "June 2015";
        $entry['Text'] = "New Up! BOX printers have arrived. These allow to print larger object at a higher accuracy.";
        $entries[] = $entry;
        $entry['icon'] = "edit";
        $entry['Time'] = "Autumn 2015";
        $entry['Text'] = "The free printing was suspended, since it resulted in too many printers being broken due to poor treatment.";
        $entries[] = $entry;
        $entry['icon'] = "user";
        $entry['Time'] = "Spring 2016";
        $entry['Text'] = "Dani Newman parts as a Lead Demonstrator and Gianluca Cidonio takes over.";
        $entries[] = $entry;
        $entry['icon'] = "cogs";
        $entry['Time'] = "April 2016";
        $entry['Text'] = "Wei Keum initiates online orders on 3D Hubs to prevent the more expensive printers from breaking.";
        $entries[] = $entry;
        $entry['icon'] = "user";
        $entry['Time'] = "Academic year 16/17";
        $entry['Text'] = "Shoufeng Yang parts and the workshop is run entirely by students, with Gianluca and later Apostolos Grammatikopolous and Katherine Crawford organising the sessions as a Lead Demonstrator and the staff support of Tim Woolman and Chris Malcome.";
        $entries[] = $entry;
        $entry['icon'] = "cogs";
        $entry['Time'] = "July 2017";
        $entry['Text'] = "The recording of prints is moved to a website built by Svitlana Braichenko, Andrii Iakovliev and Illya Khromov under the lead of Lasse Wollatz.";
        $entries[] = $entry;
        $entry['icon'] = "user";
        $entry['Time'] = "September 2017";
        $entry['Text'] = "With Andrew Hamilton a new academic takes over the workshop.";
        $entries[] = $entry;
        $entry['icon'] = "cogs";
        $entry['Time'] = "January 2018";
        $entry['Text'] = "We leave 3D Hubs and include the online prints into the website.";
        $entries[] = $entry;
        $entry['icon'] = "archive";
        $entry['Time'] = "March 2018";
        $entry['Text'] = "Several new Prusia printers are purchased, to replace the old Up! printers.";
        $entries[] = $entry;

    @endphp
    @foreach($entries as $entry)
        <li class="item">
            <div class=" row alert alert-info">
                <div class="col-sm-4 text-left"> 
                    <i class="fa fa-{{$entry['icon']}}"></i> {{$entry['Time']}}
                </div>
                <div class="col-sm-4 text-justify">{{$entry['Text']}}</div> 
            </div>
        </li>
    @endforeach
    </ul>
   {{--
    <div class="title m-b-md">
        Updates in version 1.4
    </div>
    <div class="container well text-left">
        <h3>Functionality updates</h3>
            <ol>
                <li>
                    There have been several issues with cost codes and/or module names entered in a
                    <a href="http://3dprint.clients.soton.ac.uk/printingData/create" target="_blank"><b>request a job form</b></a>.
                    Please, make sure that you type in the module name that is in the following format <b>FEEG2001-MECH</b>.
                </li>
                <li>
                    The new demonstrator workflow has been documented and is accessible <a href="http://3dprint.clients.soton.ac.uk/documents">
                        <b>here</b></a>.
                </li>
            </ol><br>
        <h3>New pages and pages look updates</h3>
            <ol>
                <li>
                    The page <a href="http://3dprint.clients.soton.ac.uk/members/index"><b>Our Team</b></a>
                    now has staff members names assembled in a more user friendly way. Notice the
                    <a type="button" class="btn btn-lg btn-info">
                        View former members
                    </a> button available for lead demonstrators and managers.
                </li>
                <li>
                    Page <a href="http://3dprint.clients.soton.ac.uk/documents"><b>For demonstrators</b></a> contains the
                    description of the demonstrator workflow as well as UP 3D printer and UP BOX manuals in addition to
                    Request a loan form.
                </li>
                <li>
                    The set of rules for students can be accessed via home page if logged out.
                </li>
                <li>
                    Extensive information on how to claim the demonstrating hours can be found on the page
                    <a href="http://3dprint.clients.soton.ac.uk/gettingPaid"><b>Getting paid</b></a>.
                </li>
            </ol><br>

        <div>
            <br>Poseted by <a href="mailto:ai1v14@soton.ac.uk?Subject=Soton3Dprint" target="_blank"><b>Andrii Iakovliev</b></a>
            and
            <a href="mailto:sb2g14.ac.uk?Subject=Soton3Dprint" target="_blank"><b>Svitlana Braichenko</b></a>
        </div>
    </div>

    <div class="title m-b-md">
        Updates in version 1.3
    </div>
    <div class="container well text-left">
        <div>
            Here we present a short outline to the updates we have made since launching the web site as well as a short
            guidance on how to manage printer issues.
        </div><br>
        <h3>New functionality</h3>
        <ol>
            <li>
                The <a href="http://3dprint.clients.soton.ac.uk/printingData/index">Pending Jobs</a> page has been updated.
                New button <a href="http://3dprint.clients.soton.ac.uk/printingData/approved">Show currently approved jobs</a> leads to the list of jobs that have just been approved by a demonstrator.
                We also added a link to display all the jobs history.
            </li>
            <li>
                The 3dhubs manager now can edit any job after it has finished by adjusting the printing time and material amount.
                Therefore, it is now possible to manage overnight jobs. And the cost tracking is more precise.
                The failed jobs requested by the 3Dhubs manager are not charged. In addition to that, while performing
                joined jobs the 3dhubs manager can request multiple jobs on the same printer.
            </li>
        </ol><br>
        <h3>How to use <a href="http://3dprint.clients.soton.ac.uk/printers/index">3D printers</a> page</h3>
        <div>
            The options of each 3D printer are <a href="http://3dprint.clients.soton.ac.uk/issues/show/1">Details</a> and
            <a href="http://3dprint.clients.soton.ac.uk/printers/update/1">Update</a>. The <a href="http://3dprint.clients.soton.ac.uk/issues/show/1">Details</a>
            button leads to the Performance history of each printer as shown below.
            <br><br>
            <div>
                <img src="/Images/view_update_resolve_printer.svg">
            </div>
            <br><br>
            The button "View/Update or Resolve" is available only for the printers with unresolved issues and
            leads to the page from which you can manage the issue.
            <br>
            The button <a href="http://3dprint.clients.soton.ac.uk/printers/update/1">Update</a> is currently available only
            to the Lead Demonstrator and provides means of updating printer records such as ID, number and etc.
            <br><br>
            If you would like update or resolve the current issue with a certain printer you just need to click on
            "View/Update or Resolve button" or you can also access issues via "3Dprinters"->
            <a href="http://3dprint.clients.soton.ac.uk/issues/index">Pending issues</a>.
            <br><br>
            <div>
                <img src="/Images/Pending_issues.svg">
            </div>
            <br><br>
            To log a new printer issue go to "3Dprinters"-><a href="http://3dprint.clients.soton.ac.uk/issues/select">Log an Issue</a>
            ->"Select printer"-><a href="http://3dprint.clients.soton.ac.uk/issues/select">Log a New Issue</a>
            or via <a href="http://3dprint.clients.soton.ac.uk">home</a>->"Issues"->"+" as shown below.
            <br><br>
            <div>
                <img src="/Images/Issues_home.svg">
            </div>
        </div>
        <div>
            <br>Poseted by <a href="mailto:ai1v14@soton.ac.uk?Subject=Soton3Dprint" target="_blank"><b>Andrii Iakovliev</b></a>
            and
            <a href="mailto:sb2g14.ac.uk?Subject=Soton3Dprint" target="_blank"><b>Svitlana Braichenko</b></a>
        </div>
    </div>
    <div class="title m-b-md">
        How to request and manage jobs
    </div>
    <div class="container well text-left">
        <div>
            <p>
            As many of you know, we have been developing a new website for improving the ease of logging prints over the past months.The website is accessible to everyone on the university network or VPN connection under <a href="http://3dprint.clients.soton.ac.uk/">http://3dprint.clients.soton.ac.uk/</a>. It will streamline the workflow of managing the printers and printing jobs and thus reduce the time you have to spend reading students handwriting, searching for their correct email and copying information in general, thus giving you more time to take care of the students in the workshop and help them with their prints or fix broken printers.
            </p>
            <p>
            In order to fully test the website and get your feedback implemented, we decided to introduce the website during a time of low traffic, meaning from today onwards. ☺ I will disable access to the google recording spreadsheet soon and everyone will have to use the new website. If you have any issues, questions or feedback, please contact either of us (emails are on the website). Please note that I will be away for the next 2 weeks, so any problems should be directly reported to <b>Andrii</b> (<a href="mailto:A.Iakovliev@soton.ac.uk">A.Iakovliev@soton.ac.uk</a>) during that time!
            </p>
            <p>
            I expect everyone to spend 10 minutes to click around the website to familiarise themselves with the website before coming to the workshop. Below is a short introduction on the most important things you need to know.
            </p>
            <p>Students should fill their details on the website and request jobs.</p>
            <img src="/Images/image003.jpg">
            <p>
            They should NOT start the print until you accept the job! As they won’t be aware of this new procedure, please do point them at the website as they get to the workshop!
            </p>
            <p>As a demonstrator you now need to log in to the web-page and click on</p>
            <img src="/Images/image005.jpg">
            <p>
            Which will link you to a page where you can manage new and approved jobs. Please check the details with the student and click accept as they start the print. If a print fails, please go from the pending jobs list to “Show Approved Jobs”. There you click the red button next to the job and say why the print failed. You can also mark jobs as completed here.
            </p>
            <p>If printers break, you can manage them from the 3D Printers->View Printers page.</p>
            <p>
            I hope the page is self-explanatory for most ways. If you have any questions of how to achieve anything you could do on the spreadsheet before but don’t know how to do now, please let us know and we will try to give a more detailed explanation. Please note that the Availability/Rota spreadsheet will remain on google for now. We do plan to remove it in the long time though so that your Gmail accounts won’t be needed any longer but you can manage all from one page ☺
            </p>
            <p>If there are any major problems while I am absent, please record the prints on a sheet of paper as we used to and I will sort things out once I am back!<br> I hope you have a great start in the weekend and hope that even if this change came without warning to you, you will soon appreciate the advantages of this new system. ☺
            </p>
            <br>Posted by <a href="mailto:l.wollatz@soton.ac.uk?Subject=Soton3Dprint" target="_blank"><b>Lasse Wollatz</b></a></p>
        </div>
    </div>
    --}}
@endsection
