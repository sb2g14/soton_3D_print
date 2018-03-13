<?php
namespace App;

use Charts;
use App\DB;

class StatisticsHelper
{
    
    private function getCountPrintsBetween($t1str,$t2str){
        $prints = \App\Prints::orderBy('created_at', 'desc')
            ->where('created_at', '>', $t2str)->where('created_at', '<', $t1str)
            ->count();
        return $prints;
    }
     
    private function getCountPrintsWorkshopBetween($t1str,$t2str){
        $prints = \App\Jobs::where('jobs.requested_online', 0)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->count();
        return $prints;
    } 
    
    private function getCountPrintsOnlineBetween($t1str,$t2str){
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

    public function createChartPrintsLastMonths($count_prints,$count_months){
        /***Total number of prints per month over the last x months (Area Chart)***/
        // Create labels
        $month_labels = [];
        foreach ($count_months as $date) {
             $month_labels[] = $date->format('M y');
        }
        // Create chart for prints over past 12 months
        $month_labels = array_reverse($month_labels);
        $count_prints = array_reverse($count_prints);
        $chart = Charts::create('area', 'highcharts')
            ->title('Prints per months')
            //->colors(['#ffffff'])
            ->template('prussian-uni')
            ->oneColor(true)
            //->background_color('')
            ->elementLabel('')
            ->legend(false)
            ->labels($month_labels)
            ->values($count_prints)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }
    
    private function getInversePrussian($n){
        /**get the prussian chart template but in reverse order with the last entry being the university blue
         * $n defines the number of required colours
         **/
        $colourset = ['#002E3B','#315765','#5e8493','#8db4c3','#bee6f6','#f1ffff'];
        $year_color = array_reverse(array_slice($colourset,0,$n));
        return $year_color;
    }

    public function createChartPrintsLastYearsPerMonth($years){
        /***Total number of prints per month comparing the past $years years (Line Chart)***/
        // get data
        $time = new \Carbon\Carbon;
        $this_month = $time->month;
        $this_year = $time->year;
        $count_prints = $this->getArrayPrintsLastMonths(12*($years-1)+$this_month);
        $count_months = $this->getArrayLastMonths(12*($years-1)+$this_month);
        // Set Colours
        $year_color = $this->getInversePrussian($years+1);
        //format data
        $year_data = [];
        $year_label = [];
        $year_data[] = array_reverse(array_slice($count_prints,0,$this_month));
        $year_label[] = $this_year;
        for ($y = 0; $y < $years; $y++){
            $year_data[] = array_reverse(array_slice($count_prints,$this_month+12*$y,12));
            $year_label[] = $this_year-$y-1;
        }
        // Create labels
        $months12 = array_slice($count_months,$this_month,12);
        $month_labels = [];
        foreach ($months12 as $date) {
             $month_labels[] = $date->format('M');
        }
        // Create chart for prints over past 12 months
        $month_labels = array_reverse($month_labels);
        $count_prints = array_reverse($count_prints);
        $chart = Charts::multi('line', 'highcharts')
            ->title('Prints per months')
            ->colors($year_color)
            //->template('shamrock-uni')
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($month_labels);
        for ($y = $years; $y >= 0; $y--){
            $chart = $chart->dataset($year_label[$y],$year_data[$y]);
        }
        $chart = $chart->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }

    public function createChartPrintsLastYears($n_years){
        /***Total number of Workshop and Online Prints per year since 2014 (Column Chart)***/
        //TODO: need to separate online and workshop prints
        $count_prints = $this->getArrayPrintsLastYears($n_years);
        $count_online = $this->getArrayOnlinePrintsLastYears($n_years);
        $years = $this->getArrayLastYears($n_years);
        // Create labels
        $labels = [];
        foreach ($years as $date) {
             $labels[] = $date->format('Y');
        }
        // Create chart for prints over past years
        $labels = array_reverse($labels);
        $count_workshop = [];
        for($i=0;$i<sizeof($count_prints);$i++) {
             $count_workshop[] = $count_prints[$i]-$count_online[$i];
        }
        $count_workshop = array_reverse($count_workshop);
        $count_online = array_reverse($count_online);
        /*$chart = Charts::multi('bar', 'highcharts')
            ->title('Prints per year')
            ->template('uni')
            ->oneColor(false)
            //->background_color('')
            ->elementLabel('')
            ->legend(true)
            ->labels($labels)
            ->dataset('workshop jobs',$count_workshop)
            ->dataset('online jobs',$count_online)
            ->responsive(true);*/
        $year_color = $this->getInversePrussian($n_years);
        $chart = Charts::create('bar', 'highcharts')
            ->title('Prints per year')
            ->colors($year_color)
            ->oneColor(false)
            ->elementLabel('')
            ->labels($labels)
            ->values($count_workshop)
            ->responsive(true);
        return $chart;
    }
    
    public function createChartUsersLastYears(){
        /***Total number of Users per year since 2014 (Column Chart)***/
        $count_users = $this->getUsersPerYear();
        $time = new \Carbon\Carbon;
        $maxyear = (int)($time->format('Y'));
        $years = $this->getArrayLastYears($maxyear-2014+1);
        // Create labels
        $labels = [];
        foreach ($years as $date) {
             $labels[] = $date->format('Y');
        }
        // Create chart for prints over past years
        $labels = array_reverse($labels);
        //$count_users = array_reverse($count_users);
        $year_color = $this->getInversePrussian($maxyear-2014+1);
        $chart = Charts::create('bar', 'highcharts')
            ->title('Users per year')
            ->template('prussian-uni')
            ->colors($year_color)
            ->oneColor(false)
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($labels)
            ->values($count_users)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }
    
    private function getPrinterType(){
        $printer_types = Printers::select('printer_type')->groupBy('printer_type')->orderBy('printer_type', 'ASC')->get();
        return $printer_types;
    }
    private function getSuccPrintsPerPrinterType(){
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
    
    public function createChartReliabilityPerPrinterType(){
        /***Ratio of Succesfull/Total number of prints per printer type (Bar or Column Chart)***/
        $prints = $this->getSuccPrintsPerPrinterType();
        $printer_types = $this->getPrinterType();
        // Create labels and values
        $labels = [];
        $values = [];
        foreach($prints as $t){
            $labels[] = $t["type"]." (".($t["sucs"]+$t["fail"])." total prints)";
            $values[] = 0.1*(int)(0.5+1000*(float)($t["sucs"])/($t["sucs"]+$t["fail"]));
        }   
        // Create chart
        $chart = Charts::create('bar', 'highcharts')
            ->title('Reliability of Printers in %')
            ->template('shamrock-uni')
            ->oneColor(true)
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($labels)
            ->values($values)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }

    public function createChartPrinterAvailability(){
        /***Creates a chart for Printer Availability and returns it.***/
        $printers_in_use = printers::where('in_use','1')->where('printer_type','!=','UP BOX')->count();
        $printers_available = printers::where('printer_status','Available')->where('in_use','0')->where('printer_type','!=','UP BOX')->count();

        $chart1 = Charts::create('percentage', 'justgage')
            ->title(false)
            ->elementLabel('Available')
            //->colors(['#C2185B'])
            ->template('coral-uni')
            ->oneColor(true)
            ->values([$printers_available,0,$printers_in_use + $printers_available])
            ->responsive(false)
            ->height(300)
            ->width(0);
        return $chart1;
    }
    
    public function createChartPrinterStatus(){
        /***Creates a chart for Printer Status and returns it.***/
        $printers_in_use = printers::where('in_use','1')->count();
        $printers_available = printers::where('printer_status','Available')->where('in_use','0')->count();
        $unavailable_printers = printers::where('printer_status','!=','Available')->where('printer_status','!=','Signed out')->where('in_use','0')->count();

        $chart1 = Charts::create('pie', 'google')
            ->title('Printers')
            ->template('uni')
            ->labels(['Available', 'In use', 'Unavailable'])
            ->legend(true)
            ->values([$printers_available,$printers_in_use,$unavailable_printers])
            ->responsive(true);
        return $chart1;
    }

    public function createChartWorkshopUsage(){
        /***Creates a chart to show how busy the workshop is at specific times and returns it.***/
        // Initiate variables
        $timeinterval = 1; //in hours but gives minutes accuracy
        $Nweeks = 5; //number of weeks to go into the past to create average
        $open_days = [];
        $printersbusy = [];
        $timesofday = [];
        $time = new \Carbon\Carbon;
        $time->setTime(0, 0, 0);
        for($i=9; $i<=18; $i+=$timeinterval){
            $timesofday[] = $time->copy()->addMinutes((int)(60*$i));
            $printersbusy[] = 0;
        }

        // Get the various of prints for the past 4 weeks
        $time = new \Carbon\Carbon;
        $time = $time->subDay();
        $t1str = $time->format('Y-m-d')." 00:00:00";
        $t2str = $time->subWeeks($Nweeks)->format('Y-m-d')." 00:00:00";
        //get all prints excluding online-prints
        $prints = \App\Jobs::where('jobs.requested_online', 0)
            ->join('jobs_prints', 'jobs.id', '=', 'jobs_prints.jobs_id')
            ->join('prints', 'prints.id', '=', 'jobs_prints.prints_id')
            ->orderBy('prints.created_at', 'desc')
            ->where('prints.created_at', '>', $t2str)->where('prints.created_at', '<', $t1str)
            ->select('prints.created_at','prints.updated_at')->get();

        // Count the number of different days and assign prints to time histogram
        foreach ($prints as $print) { //iterate over all the prints
            for($i=0; $i<count($timesofday); $i++){ 
                $t1 = $print->created_at;
                $t2 = $print->updated_at;
                //check if date of print is new
                $day = $t1->format('Y-m-d');
                if(!in_array($day, $open_days)){
                    $open_days[] = $day;
                }
                //check if the timestamp falls into the print usage interval
                $ti = $timesofday[$i];
                //need to adjust date, since we only want to compare the time
                $now = new \Carbon\Carbon;
                $ti->setDate($now->year,$now->month,$now->day);
                $t1->setDate($now->year,$now->month,$now->day);
                $t2->setDate($now->year,$now->month,$now->day);
                //if($t1<=$ti && $ti<=$t2){
                if($ti->between($t1,$t2)){
                    //calculate overlap as
                    $ovstart = max($t1,$ti->subMinutes(30*$timeinterval));
                    $ovend = min($t2,$ti->addMinutes(30*$timeinterval));
                    $overlap = $ovend->diffInMinutes($ovstart);
                    $printersbusy[$i]+=(float)($overlap)/60;
                    //add 1 to the timestamp busyness
                    //$printersbusy[$i]++;
                }
            }
        }
        // Normalise the data
        $Ndays = count($open_days);
        if($Ndays == 0){
            $Ndays = 1;
        }
        for($i=0; $i<count($printersbusy); $i++){
            $printersbusy[$i] = $printersbusy[$i]/$Ndays;
            $printersbusy[$i] = $printersbusy[$i]/$timeinterval;
        }
        // Create chart for prints over past 12 months
        $chart_labels = $timesofday;
        for($i=0; $i<count($chart_labels); $i++){
             $chart_labels[$i] = $chart_labels[$i]->format('H:i');
        }
        $chart_values = $printersbusy;
        $chart = Charts::create('bar', 'highcharts')
            ->title('Average number of simultaneous prints during the last '.$Ndays.' sessions')
            ->template('coral-uni')
            ->oneColor(true)
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($chart_labels)
            ->values($chart_values)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
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

    private function getUsersPerYear(){
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
