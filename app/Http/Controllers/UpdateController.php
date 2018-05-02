<?php

namespace App\Http\Controllers;

use App\Jobs;
use App\Prints;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


class UpdateController extends Controller
{
    public function index()
    {
        return view('loan');
    }
    
    private function addGuestUser(){
        $user = User::where('id',100)->first();
        if(!$user){
            $user = new User;
            $user->id = 100;
            $user->name = "customer";
            $user->email = "customer@soton.ac.uk";
            $user->password = 'NotARealPasswordHashSinceNotUsed';
            $user->save();
        }
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
    
    private function fillJobDates(){
        $jobs = Jobs::whereNull('finished_at')
            ->where(function($query) { 
                return $query->where('status','Success')->orWhere('status','Failed');
                })
            ->get();
        foreach($jobs as $job){
            $update = new Carbon($job->updated_at);
            $start = $job->approved_at;
            $duration = $job->total_duration;
            $duration = explode(':',$duration);
            $endByPrint = $job->updated_at;
            if(count($duration) == 3){
                $endByPrint = new Carbon($start);
                $endByPrint = $endByPrint->addHours($duration[0])->addMinutes($duration[1]);
            }
            // Compare Finish Time by Update and print
            if($update->diffInHours($endByPrint, false) > 1 && $job->requested_online == 0){
                $finish = $endByPrint;
            }else{
                $finish = $update;
            }
            $job -> update(array(
                'accepted_at' => $start,
                'finished_at' => $finish
            ));
        }   
    }

    private function fillPrintDates(){
        $prints = Prints::whereNull('finished_at')
            ->where(function($q){$q->where('status','Success')->orWhere('status','Failed');})
            ->get();
        foreach($prints as $print){
            $update = new Carbon($print->updated_at);
            $start = $print->created_at;
            $duration = $print->time;
            $duration = explode(':',$duration);
            $end1 = $print->finished_at;
            if(!$end1){
                $end1 = $print->updated_at;
            }else{
                $end1 = new Carbon($end1);
            }
            if(count($duration) == 3){
                $end1 = new Carbon($start);
                $end1 = $end1->addHours($duration[0])->addMinutes($duration[1]);
            }
            if($update->diffInHours($end1, false) > 3){
                $finish = $end1;
            }else{
                $finish = $update;
            }
            $print -> update(array(
                'finished_at' => $finish
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
        //IMPORTANT! RUN THIS FIRST:
        //ALTER TABLE `jobs` ADD COLUMN `accepted_at` TIMESTAMP NULL, ADD COLUMN `finished_at` TIMESTAMP NULL;
        //ALTER TABLE `prints` ADD COLUMN `finished_at` TIMESTAMP NULL;
        // now we save the updated_at to finished_at!
        $this->fillJobDates();
        $this->fillPrintDates();
        // then we can clean other columns without loosing information
        $this->addJobTitles();
        $this->correct3DHubsToOnline();
        $this->setJobStaffIDs();
        $this->setPrintStaffIDs();
        $this->addGuestUser();
        return redirect()->home();
    }
}
