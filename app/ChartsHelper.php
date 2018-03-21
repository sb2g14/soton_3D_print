<?php
namespace App;

use Charts;
use App\DB;
use App\StatisticsHelper;

class ChartsHelper
{
    
    private function getInversePrussian($n,$template){
        /**get the prussian chart template but in reverse order with the last entry being the university blue
         * $n defines the number of required colours
         **/
        //$colourset = ['#002E3B','#315765','#5e8493','#8db4c3','#bee6f6','#f1ffff'];
        $chartcfg = config('charts');
        $colourset = $chartcfg['templates'][$template];
        $year_color = array_reverse(array_slice($colourset,0,$n));
        return $year_color;
    }

    public function createChartPrintsLastMonths($count_prints,$count_months,$template){
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
            ->template($template)
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
    
    

    public function createChartPrintsLastYearsPerMonth($years,$template){
        /***Total number of prints per month comparing the past $years years (Line Chart)***/
        $stats = new StatisticsHelper();
        // get data
        $time = new \Carbon\Carbon;
        $this_month = $time->month;
        $this_year = $time->year;
        $count_prints = $stats->getArrayPrintsLastMonths(12*($years-1)+$this_month);
        $count_months = $stats->getArrayLastMonths(12*($years-1)+$this_month);
        // Set Colours
        $year_color = $this->getInversePrussian($years+1,$template);
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

    public function createChartPrintsLastYears($n_years,$template){
        /***Total number of Workshop and Online Prints per year since 2014 (Column Chart)***/
        //TODO: need to separate online and workshop prints
        $stats = new StatisticsHelper();
        $count_prints = $stats->getArrayPrintsLastYears($n_years);
        $count_online = $stats->getArrayOnlinePrintsLastYears($n_years);
        $years = $stats->getArrayLastYears($n_years);
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
        $year_color = $this->getInversePrussian($n_years,$template);
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
    
    public function createChartUsersLastYears($template){
        /***Total number of Users per year since 2014 (Column Chart)***/
        $stats = new StatisticsHelper();
        $count_users = $stats->getUsersPerYear();
        $time = new \Carbon\Carbon;
        $maxyear = (int)($time->format('Y'));
        $years = $stats->getArrayLastYears($maxyear-2014+1);
        // Create labels
        $labels = [];
        foreach ($years as $date) {
             $labels[] = $date->format('Y');
        }
        // Create chart for prints over past years
        $labels = array_reverse($labels);
        //$count_users = array_reverse($count_users);
        $year_color = $this->getInversePrussian($maxyear-2014+1,$template);
        $chart = Charts::create('bar', 'highcharts')
            ->title('Users per year')
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
    
    
    public function createChartReliabilityPerPrinterType($template){
        /***Ratio of Succesfull/Total number of prints per printer type (Bar or Column Chart)***/
        $stats = new StatisticsHelper();
        $prints = $stats->getSuccPrintsPerPrinterType();
        $printer_types = $stats->getPrinterType();
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
            ->template($template)
            ->oneColor(false)
            ->elementLabel('')
            ->legend('')
            ->labels($labels)
            ->values($values)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }

    public function createChartPrinterAvailability($template){
        /***Creates a chart for Printer Availability and returns it.***/
        $printers_in_use = printers::where('in_use','1')->where('printer_type','!=','UP BOX')->count();
        $printers_available = printers::where('printer_status','Available')->where('in_use','0')->where('printer_type','!=','UP BOX')->count();

        $chart1 = Charts::create('percentage', 'justgage')
            ->title(false)
            ->elementLabel('Available')
            //->colors(['#C2185B'])
            ->template($template)
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
            ->oneColor(false)
            ->labels(['Available', 'In use', 'Unavailable'])
            ->legend(true)
            ->values([$printers_available,$printers_in_use,$unavailable_printers])
            ->responsive(true);
        return $chart1;
    }
     

    public function createChartWorkshopUsage($template){
        /***Creates a chart to show how busy the workshop is at specific times and returns it.***/
        $stats = new StatisticsHelper();
        // Initiate variables
        $timeinterval = 1; //in hours but gives minutes accuracy
        $Nweeks = 4; //number of weeks to go into the past to create average
        $open_days = [];
        $printersbusy = [];
        $timesofday = [];
        $time = new \Carbon\Carbon;
        $time->setTime(0, 0, 0);
        for($i=9; $i<=18; $i+=$timeinterval){
            $timesofday[] = $time->copy()->addMinutes((int)(60*$i));
            $printersbusy[] = 0;
        }

        // Get the workshop prints for the past weeks 
        $prints = $stats->getPrintsLastWeeks($Nweeks);

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
                $ti = new \Carbon\Carbon($timesofday[$i]);
                if($stats->isTimeBetween($ti,$t1,$t2)){
                    $ti1 = new \Carbon\Carbon($ti);
                    $ti2 = new \Carbon\Carbon($ti);
                    $ti1 = $ti1->subMinutes(30*$timeinterval);
                    $ti2 = $ti2->addMinutes(30*$timeinterval);
                    //calculate overlap as
                    $overlap = $stats->calcTimeOverlap($t1,$t2,$ti1,$ti2);
                    $printersbusy[$i]+=(float)($overlap)/60;
                    //add 1 to the timestamp busyness
                    //$printersbusy[$i]++;
                }
            }
        }
        // Normalise the data
        $Ndays = count($open_days);
        $Nprints = count($prints);
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
            ->title('Average number of simultaneous prints during the last '.$Ndays.' sessions') //from '.$Nprints.' prints.
            ->template($template)
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
}
?>
