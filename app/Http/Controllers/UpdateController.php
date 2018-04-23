<?php

namespace App\Http\Controllers;
use App\Jobs;
use App\Prints;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function index()
    {
        return view('loan');
    }
    
    private function correct3DHubsToOnline(){
        $prints = Prints::where('print_comment','like', '%3D Hubs%')->get();
        foreach($prints as $print){
            $job = $print->jobs()->first();
            $job -> update(array(
                'requested_online' => 1
            ));
        }   
    }
    
    private function addJobTitles(){
        $jobs = Jobs::whereNull('job_title')->get();
        foreach($jobs as $job){
            $newTitle = $job->use_case;
            $job -> update(array(
                'job_title' => $newTitle
            ));
        }   
    }
    
    private function setJobStaffIDs(){
        $systemID = 64;
        $jobs = Jobs::whereNull('job_approved_by')->whereNotNull('approved_at')->get(); 
        foreach($jobs as $job){
            $job -> update(array(
                'job_approved_by' => $systemID
            ));
        } 
        // Now admin can execute
        // ALTER TABLE `jobs` ADD CONSTRAINT job_approved_by_fk FOREIGN KEY (job_approved_by) 
        //   REFERENCES staff(id) ON UPDATE RESTRICT;
        
        $jobs = Jobs::whereNull('job_finished_by')->where('status','Success')->get(); 
        foreach($jobs as $job){
            $job -> update(array(
                'job_finished_by' => $systemID
            ));
        }
        // Now admin can execute 
        // ALTER TABLE `jobs` ADD CONSTRAINT job_finished_by_fk FOREIGN KEY (job_finished_by) 
        //   REFERENCES staff(id) ON UPDATE RESTRICT;
    }  
    
    private function setPrintStaffIDs(){
        $systemID = 64;
        
        $prints = Prints::whereNull('print_started_by')->where('status','!=','Waiting')->get(); 
        foreach($prints as $print){
            $print -> update(array(
                'print_started_by' => $systemID
            ));
        } 
        // Now admin can execute
        // ALTER TABLE `prints` ADD CONSTRAINT print_started_by_fk FOREIGN KEY (print_started_by) 
        //   REFERENCES staff(id) ON UPDATE RESTRICT;

        $prints = Prints::whereNull('print_finished_by')->where('status','Success')->get(); 
        foreach($prints as $print){
            $print -> update(array(
                'print_finished_by' => $systemID
            ));
        } 
        // Now admin can execute 
        // ALTER TABLE `prints` ADD CONSTRAINT print_finished_by_fk FOREIGN KEY (print_finished_by) 
        //   REFERENCES staff(id) ON UPDATE RESTRICT;
    }  
    
    public function doUpdate()
    {
        $this->addJobTitles();
        $this->correct3DHubsToOnline();
        $this->setJobStaffIDs();
        $this->setPrintStaffIDs();
        return redirect()->home();
    }
}
