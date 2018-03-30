<?php
namespace App;

//use Charts;
use App\DB;

class StatisticsHelper
{
    
    public function getCountPrintsBetween($t1str,$t2str){
        $prints = \App\Prints::orderBy('created_at', 'desc')
            ->where('created_at', '>', $t2str)->where('created_at', '<', $t1str)
            ->count();
        return $prints;
    }
     
    public function getCountPrintsWorkshopBetween($t1str,$t2str){
        $prints = \App\Jobs::where('jobs.requested_online', 0)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->count();
        return $prints;
    } 
    
    public function getCountPrintsOnlineBetween($t1str,$t2str){
        $prints = \App\Jobs::where('jobs.requested_online', 1)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->count();
        return $prints;
    }    

    private function getArrayPrintsLastXs($n,$format,$format2,$months){
        // Call the prints model to extract statistical data
        $count_prints = [];
        // Count the number of prints since the beginning of the current month
        $time = new \Carbon\Carbon;
        $t1str = $time->toDateTimeString();
        $t2str = $time->format($format).$format2;
        $prints = $this->getCountPrintsBetween($t1str,$t2str);
        $count_prints[] = $prints;
        // Count the number of prints for the last year
        for($i=0; $i<$n-1; $i++){
            $t1str = $time->format($format).$format2;
            $time = $time->subMonths($months);
            $t2str = $time->format($format).$format2;
            $prints = $this->getCountPrintsBetween($t1str,$t2str);
            $count_prints[] = $prints;
        }
        return $count_prints;
    }  
    
    private function getArrayOnlinePrintsLastXs($n,$format,$format2,$months){
        // Call the prints model to extract statistical data
        $count_prints = [];
        // Count the number of prints since the beginning of the current month
        $time = new \Carbon\Carbon;
        $t1str = $time->toDateTimeString();
        $t2str = $time->format($format).$format2;
        $prints = $this->getCountPrintsOnlineBetween($t1str,$t2str);
        $count_prints[] = $prints;
        // Count the number of prints for the last year
        for($i=0; $i<$n-1; $i++){
            $t1str = $time->format($format).$format2;
            $time = $time->subMonths($months);
            $t2str = $time->format($format).$format2;
            $prints = $this->getCountPrintsOnlineBetween($t1str,$t2str);
            $count_prints[] = $prints;
        }
        return $count_prints;
    }  
    
    public function getArrayPrintsLastMonths($n_months){
        $count_prints = $this->getArrayPrintsLastXs($n_months,'Y-m',"-01 00:00:00",1);
        return $count_prints;
    }
    
    public function getArrayPrintsLastYears($n_years){
        $count_prints = $this->getArrayPrintsLastXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_prints;
    }
    
    public function getArrayOnlinePrintsLastYears($n_years){
        $count_prints = $this->getArrayOnlinePrintsLastXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_prints;
    }

    public function getPrintsLastWeeks($n_weeks){
        $time = new \Carbon\Carbon;
        $time = $time->subDay();
        $t1str = $time->format('Y-m-d')." 00:00:00";
        $t2str = $time->subWeeks($n_weeks)->format('Y-m-d')." 00:00:00";
        //get all prints excluding online-prints
        $prints = \App\Jobs::where('jobs.requested_online', 0)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->select('prints.created_at','prints.updated_at')->get();
        return $prints;
    }
    
    private function getArrayLastTimeXs($n,$format,$format2,$months){
        $count = [];
        $time = new \Carbon\Carbon;
        $t2str = $time->format($format).$format2;
        $count[] = new \Carbon\Carbon($t2str);
        // Count the number of prints for the last year
        for($i=0; $i<$n-1; $i++){
            $time = $time->subMonths($months);
            $t2str = $time->format($format).$format2;
            $count[] = new \Carbon\Carbon($t2str);
        }
        return $count;
    }
    

    public function getArrayLastMonths($n_months){
        $count_months = $this->getArrayLastTimeXs($n_months,'Y-m',"-01 00:00:00",1);
        /*$time = new \Carbon\Carbon;
        $t2str = $time->format('Y-m')."-01 00:00:00";
        $count_months[] = new \Carbon\Carbon($t2str);
        // Count the number of prints for the last year
        for($i=0; $i<$n_months-1; $i++){
            $time = $time->subMonth();
            $t2str = $time->format('Y-m')."-01 00:00:00";
            $count_months[] = new \Carbon\Carbon($t2str);
        }*/
        return $count_months;
    }
    
    public function getArrayLastYears($n_years){
        /*$count = [];
        $time = new \Carbon\Carbon;
        $t2str = $time->format('Y')."-01-01 00:00:00";
        $count[] = new \Carbon\Carbon($t2str);
        // Count the number of prints for the last year
        for($i=0; $i<$n_years-1; $i++){
            $time = $time->subYear();
            $t2str = $time->format('Y')."-01-01 00:00:00";
            $count[] = new \Carbon\Carbon($t2str);
        }*/
        $count_years = $this->getArrayLastTimeXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_years;
    }
      
    public function getPrinterType(){
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->orderBy('printer_type', 'ASC')->get();
        return $printer_types;
    }
    public function getSuccPrintsPerPrinterType(){
        /***Get Number of Successful Prints per printer Type***/
        //$prints = DB::statement('SELECT printers.printer_type, COUNT(prints.id) AS count FROM prints INNER JOIN printers ON prints.printers_id = printers.id WHERE prints.status = "Success" GROUP BY printers.printer_type');
        $printsSucs = \App\Prints::join('printers', function($join) {$join->on('prints.printers_id', '=', 'printers.id');})
            ->selectRaw('COUNT(prints.id) AS CountSuccess')
            ->addSelect('printers.printer_type')
            ->where('prints.status', '=', 'Success')
            ->groupBy('printers.printer_type')
            ->orderBy('printers.printer_type', 'ASC')
            ->get();
        $printsFail = \App\Prints::join('printers', function($join) {$join->on('prints.printers_id', '=', 'printers.id');})
            ->selectRaw('COUNT(prints.id) AS CountFailed')
            ->addSelect('printers.printer_type')
            ->where('prints.status', '=', 'Failed')
            ->groupBy('printers.printer_type')
            ->orderBy('printers.printer_type', 'ASC')
            ->get();
        $prints = [];
        for($i=0;$i<sizeof($printsSucs);$i++){
            $prints[] = array(
                "type"=>$printsSucs[$i]->printer_type,
                "sucs"=>$printsSucs[$i]->CountSuccess,
                "fail"=>$printsFail[$i]->CountFailed
            );
        }
        return $prints;
    }
    
    
    public function isTimeBetween($ti,$t1,$t2){
        //need to adjust date, since we only want to compare the time
        $now = new \Carbon\Carbon;
        $ti->setDate($now->year,$now->month,$now->day);
        $t1->setDate($now->year,$now->month,$now->day);
        $t2->setDate($now->year,$now->month,$now->day);
        $ans = false;
        if($ti->between($t1,$t2)){
            $ans = true;
        }
        return $ans;
    }
    
    /**
     * calculate the overlap of an event from te1 to te2 and an interval from ti1 to ti2 in minutes
     */
    public function calcTimeOverlap($te1,$te2,$ti1,$ti2){
        //calculate overlap as
        $ovstart = max($te1,$ti1);
        $ovend = min($te2,$ti2);
        $overlap = $ovend->diffInMinutes($ovstart);
        return $overlap;
    }
    
    private function getUsersInYear($year){
        //look at all the jobs from last year and count the number of different users.
        //$time = new \Carbon\Carbon;
        $t1str = ($year+1)."-01-01 00:00:00";
        //$time = $time->subYear();
        $t2str = $year."-01-01 00:00:00";
        $count_users = \App\Jobs::where('created_at', '>', $t2str)
            ->where('created_at', '<', $t1str)->select('customer_id')->groupBy('customer_id')->get();
        $count_users = $count_users->count();
        return $count_users;
    }

    public function getUsersPerYear(){
        $time = new \Carbon\Carbon;
        $maxyear = (int)($time->format('Y'));
        $count_users = [];
        for($y=2014;$y<=$maxyear;$y++){
            $count_users[] = $this->getUsersInYear($y);
        }
        return $count_users;
    }
    
    public function getUsersLastYear(){
        //look at all the jobs from last year and count the number of different users.
        $time = new \Carbon\Carbon;
        $year = (int)($time->format('Y'))-1;
        $count_users = $this->getUsersInYear($year);
        return $count_users;
    }

    public function getMaterialTotal(){
        // returns the Material since creation in kg as a string with unit
        $count_material = \App\Prints::select('material_amount')->get();
        $count_material = $count_material->sum('material_amount');
        $count_material = (int)(0.5+(float)($count_material)/1000);
        $count_material = $count_material." kg";
        return $count_material;
    }
    
    public function getArrayMemberStats($id){
        /**takes a members database id and returns an array of statistical data for that member**/
        $stats = [];
        $member = \App\Staff::where('id',$id)->first();
        $stats["prints_approved"] = \App\Staff::where('staff.id',$id)->join('jobs', 'jobs.job_approved_by', '=', 'staff.id')->count();
        $stats["prints_completed"] = \App\Staff::where('staff.id',$id)->join('jobs', 'jobs.job_finished_by', '=', 'staff.id')->count();
        $stats["issues_raised"] = \App\Staff::where('staff.id',$id)->join('fault_datas', 'fault_datas.staff_id_created_issue', '=', 'staff.id')->count();
        $stats["issues_closed"] = \App\Staff::where('staff.id',$id)->join('fault_datas', 'fault_datas.staff_id_resolved_issue', '=', 'staff.id')->count();
        return $stats;
    }
}
?>
