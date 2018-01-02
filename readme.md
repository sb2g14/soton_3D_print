## 3dprint.clients.soton.ac.uk web site 

## Database updates
### Linux/MacOS
- Dump lates database with mysql dump 
```mysqldump -u root -p[root_password] [database_name] > dumpfilename.sql```
- Feed the dump file into the working database
```mysqldump -u root -p[root_password] [database_name] < dumpfilename.sql```
### Windows
Do the same but you may encounter issues with ">" and "<". Look for supstitutions online. Possibly "-e"


## Version 1.4
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
  </ol>

## Version 1.3

- How to use page with 3D printers?  
(http://3dprint.clients.soton.ac.uk/printers/index)

- Printer performance in printer details 
(http://3dprint.clients.soton.ac.uk/issues/show/1)

- If you would like update or resolve the current issue with a certain printer you just need to click on Viw/Update or Resolve button or access issues via 3Dprinters->Pending issues

- To log a new printer issue go to 3Dprinters->Log an Issue->Select printer->Log a New Issue or via home->Issues->+

- Updated Pending Jobs page. New button "Show currently approved jobs" leads to the list of jobs that have just been approved by a demonstrator. We added link to display all the jobs history. (As requested by some of you).

- 3Dhubs manager now can edit the job after it has finished by adjusting the printing time and material amount. Therefore, it is now possible to manage overnight jobs. And the cost tracking is more precise. The failed jobs requested by the 3Dhubs manager are not charged. In addition to that, while performing joined jobs the 3dhubs menager can reqest multiple jobs on the same printer. 



Remember to fulfill all license requirements for the pulled packages ASAP...


## License

The [MIT license](http://opensource.org/licenses/MIT).


