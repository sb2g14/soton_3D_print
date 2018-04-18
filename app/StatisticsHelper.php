<?php
namespace App;
use App\DB;

/**
StatisticsHelper is a class providing a variety of functions for different cross-resource statistics
It is mainly called from the ChartsHelper, which creates visual representations of the statistical data
**/
class StatisticsHelper
{
    
    /** Get the number of Prints between date-time 1 and date-time 2, 
     * where t1str and t2str are strings containing a date in database format.
     **/
    public function getCountPrintsBetween($t1str,$t2str){
        $prints = \App\Prints::orderBy('created_at', 'desc')
            ->where('created_at', '>', $t2str)->where('created_at', '<', $t1str)
            ->count();
        return $prints;
    }
    
    /** Get the number of Prints between date-time 1 and date-time 2 that were done in the workshop, 
     * where t1str and t2str are strings containing a date in database format.
     **/
    public function getCountPrintsWorkshopBetween($t1str,$t2str){
        $prints = \App\Jobs::where('jobs.requested_online', 0)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->count();
        return $prints;
    } 
    
    /** Get the number of Prints between date-time 1 and date-time 2 that were done as part of an online order, 
     * where t1str and t2str are strings containing a date in database format.
     **/
    public function getCountPrintsOnlineBetween($t1str,$t2str){
        $prints = \App\Jobs::where('jobs.requested_online', 1)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->count();
        return $prints;
    }    

    /** Get the number of Prints for the last $n times in intervals of $months, 
     * $n is the number of intervals to go back,
     * $format is the Carbon format string to use
     * $format2 is the fixed formatting string to append (this can be merged into $format)
     * $months the length of one interval in months (needs to be an integer!)
     **/
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
    
    /** Get the number of Prints done for online orders for the last $n times in intervals of $months, 
     * $n is the number of intervals to go back,
     * $format is the Carbon format string to use
     * $format2 is the fixed formatting string to append (this can be merged into $format)
     * $months the length of one interval in months (needs to be an integer!)
     **/
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
    
    /** Get an Array with the number of Prints for the last $n months
     **/
    public function getArrayPrintsLastMonths($n_months){
        $count_prints = $this->getArrayPrintsLastXs($n_months,'Y-m',"-01 00:00:00",1);
        return $count_prints;
    }
    
    /** Get an Array with the number of Prints for the last $n years
     **/
    public function getArrayPrintsLastYears($n_years){
        $count_prints = $this->getArrayPrintsLastXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_prints;
    }
    
    /** Get an Array with the number of Prints done for online orders for the last $n years
     **/
    public function getArrayOnlinePrintsLastYears($n_years){
        $count_prints = $this->getArrayOnlinePrintsLastXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_prints;
    }
    
    /** Get an Array with the number of Prints for the last $n weeks
     **/
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
    
    /** Get an Array with the Carbon times for the last $n intervals, where
     * $format is the Carbon format to use
     * $format2 is the string to append in the end (should be merged with format)
     * $months is the number of months, one interval is long (integer)
     **/
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
    
    /** Get an Array with the Carbon times for the last $n_months months
     **/
    public function getArrayLastMonths($n_months){
        $count_months = $this->getArrayLastTimeXs($n_months,'Y-m',"-01 00:00:00",1);
        return $count_months;
    }
    
    /** Get an Array with the Carbon times for the last $n_months years
     **/
    public function getArrayLastYears($n_years){
        $count_years = $this->getArrayLastTimeXs($n_years,'Y',"-01-01 00:00:00",12);
        return $count_years;
    }
    
    /** Get an Array with all the printer types
     **/
    public function getPrinterType(){
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->orderBy('printer_type', 'ASC')->get();
        return $printer_types;
    }
    
    /** Get an Array with the successfull and failed prints grouped by printer type
     **/
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
        $rates = [];
        for($i=0;$i<sizeof($printsSucs);$i++){
            $rates[] = array(
                "type"=>$printsSucs[$i]->printer_type,
                "sucs"=>$printsSucs[$i]->CountSuccess,
                "fail"=>$printsFail[$i]->CountFailed
            );
        }
        return $rates;
    }
    
    /** Checks if the time of $ti is between $t1 and $t2, ignores the date
     **/
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
        //TODO: in charts controller there is afunction using this, but I need to check that it only passes the successfull prints!
        return $overlap;
    }
    
    /**
     * returns the number of users within one year
     * $year specifies the year to look at as a four digit integer
     **/
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
    
    /**
     * returns an array with the number of users per year since 2014
     **/
    public function getUsersPerYear(){
        $time = new \Carbon\Carbon;
        $maxyear = (int)($time->format('Y'));
        $count_users = [];
        for($y=2014;$y<=$maxyear;$y++){
            $count_users[] = $this->getUsersInYear($y);
        }
        return $count_users;
    }
    
    /**
     * returns the number of users last year
     **/
    public function getUsersLastYear(){
        //look at all the jobs from last year and count the number of different users.
        $time = new \Carbon\Carbon;
        $year = (int)($time->format('Y'))-1;
        $count_users = $this->getUsersInYear($year);
        return $count_users;
    }
    
    /**
     * returns the total material used by all prints since creation in kg as a string with unit
     **/
    public function getMaterialTotal(){
        $count_material = \App\Prints::where('status','Success')->select('material_amount')->get();
        $count_material = $count_material->sum('material_amount');
        $count_material = (int)(0.5+(float)($count_material)/1000);
        $count_material = $count_material." kg";
        return $count_material;
    }
    
    /**
     * takes a members database id and returns an array of statistical data for that member
     **/
    public function getArrayMemberStats($id){
        
        $stats = [];
        $member = \App\Staff::where('id',$id)->first();
        // Number of prints approved by this staff
        $stats["prints_approved"] = \App\Staff::where('staff.id',$id)->join('jobs', 'jobs.job_approved_by', '=', 'staff.id')->count();
        // Number of prints marked as completed by this staff
        $stats["prints_completed"] = \App\Staff::where('staff.id',$id)->join('jobs', 'jobs.job_finished_by', '=', 'staff.id')->count();
        // Number of printer issues raised by this staff
        $stats["issues_raised"] = \App\Staff::where('staff.id',$id)->join('fault_datas', 'fault_datas.staff_id_created_issue', '=', 'staff.id')->count();
        // Number of printer issues resolved by this staff
        $stats["issues_closed"] = \App\Staff::where('staff.id',$id)->join('fault_datas', 'fault_datas.staff_id_resolved_issue', '=', 'staff.id')->count();
        return $stats;
    }
}
?>
