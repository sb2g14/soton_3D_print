<?php

namespace App\Http\Controllers;

use App\posts;
use App\printers;
use App\Prints;
use App\Announcement;
use App\PublicAnnouncements;
use App\Rules\Printer;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use App\FaultData;
use Charts;

class PostsController extends Controller
{
    // Specify pages available to an unauthenticated user

    public function __construct()
    {

        $this->middleware('auth')->except(['index','show']);

    }

    private function getArrayPrintsLastMonths($n_months){
        // Call the prints model to extract statistical data
        $count_prints = [];
        // Count the number of prints since the beginning of the current month
        $time = new \Carbon\Carbon;
        $t1str = $time->toDateTimeString();
        $t2str = $time->format('Y-m')."-01 00:00:00";
        $prints = \App\Prints::orderBy('created_at', 'desc')->where('created_at', '>', $t2str)
            ->where('created_at', '<', $t1str)->count();
        $count_prints[] = $prints;
        // Count the number of prints for the last year
        for($i=0; $i<$n_months-1; $i++){
            $t1str = $time->format('Y-m')."-01 00:00:00";
            $time = $time->subMonth();
            $t2str = $time->format('Y-m')."-01 00:00:00";
            $prints = \App\Prints::orderBy('created_at', 'desc')->where('created_at', '>', $t2str)
                ->where('created_at', '<', $t1str)->count();
            $count_prints[] = $prints;
        }
        return $count_prints;
    }

    private function getArrayLastMonths($n_months){
        $count_months = [];
        $time = new \Carbon\Carbon;
        $t2str = $time->format('Y-m')."-01 00:00:00";
        $count_months[] = new \Carbon\Carbon($t2str);
        // Count the number of prints for the last year
        for($i=0; $i<$n_months-1; $i++){
            $time = $time->subMonth();
            $t2str = $time->format('Y-m')."-01 00:00:00";
            $count_months[] = new \Carbon\Carbon($t2str);
        }
        return $count_months;
    }

    private function createChartPrintsLastMonths($count_prints,$count_months){
        
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
            ->colors(['#00796B'])
            //->colors(['#ffffff'])
            ->template('teal-material')
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($month_labels)
            ->values($count_prints)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }

    private function createChartPrinterAvailability(){
        // Creates a chart for Printer Availability and returns it.
        $printers_in_use = printers::where('in_use','1')->where('printer_type','!=','UP BOX')->count();
        $printers_available = printers::where('printer_status','Available')->where('in_use','0')->where('printer_type','!=','UP BOX')->count();
        //$unavailable_printers = printers::where('printer_status','!=','Available')->where('printer_status','!=','Signed out')->where('in_use','0')->count();

//        $chart1 = Charts::create('pie', 'highcharts')
//            ->title('Printers')
//            ->colors(['#00796B','#C2185B','#005C85'])
//            ->labels(['Available', 'In use', 'Unavailable'])
//            ->values([$printers_available,$printers_in_use,$unavailable_printers])
//            ->dimensions(400,200)
//            ->responsive(false);

        $chart1 = Charts::create('percentage', 'justgage')
            ->title(false)
            ->elementLabel('Available')
            //->colors(['#C2185B'])
            ->values([$printers_available,0,$printers_in_use + $printers_available])
            ->responsive(false)
            ->height(300)
            ->width(0);
        return $chart1;
    }

    private function createChartWorkshopUsage(){
        // Creates a chart to show how busy the workshop is at specific times and returns it.
        // Initiate variables
        $timeinterval = 0.25; //in hours but gives minutes accuracy
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
                if($t1<=$ti && $ti<=$t2){
                    // add 1 to the timestamp busyness
                    $printersbusy[$i]++;
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
        }
        // Create chart for prints over past 12 months
        $chart_labels = $timesofday;
        for($i=0; $i<count($chart_labels); $i++){
             $chart_labels[$i] = $chart_labels[$i]->format('H:i');
        }
        $chart_values = $printersbusy;
        $chart = Charts::create('area', 'highcharts')
            ->title('Busyness of the workshop over the day')
            ->colors(['#00796B'])
            //->colors(['#ffffff'])
            ->template('teal-material')
            //->background_color('')
            ->elementLabel('')
            ->legend('')
            ->labels($chart_labels)
            ->values($chart_values)
            ->dimensions(400,300)
            ->responsive(true);
        return $chart;
    }

    private function getIssues(){
//        $posts =  posts::orderBy('created_at', 'desc')->take(20)->get();
//        $posts -> toArray($posts);
//        $post_last = posts::orderBy('created_at','desc')->first();
        // Getting post and fault data and combining it
        $faults = FaultData::select('id', 'title', 'body', 'created_at', 'staff_id_created_issue as staff_id', 'printers_id')
        ->where('resolved', 0);
        $posts = Posts::addSelect('id', 'title', 'body', 'created_at', 'staff_id')->selectRaw('NULL AS printers_id')->where('resolved', 0);
        $issues = $faults->unionAll($posts)->orderBy('created_at','desc')->get();
        return $issues;
    }
    
    private function getUsersLastYear(){
        //look at all the jobs from last year and count the number of different users.
        $time = new \Carbon\Carbon;
        $t1str = $time->format('Y')."-01-01 00:00:00";
        $time = $time->subYear();
        $t2str = $time->format('Y')."-01-01 00:00:00";
        $count_users = \App\Jobs::where('created_at', '>', $t2str)
            ->where('created_at', '<', $t1str)->select('customer_id')->groupBy('customer_id')->get();
        $count_users = $count_users->count();
        return $count_users;
    }

    private function getMaterialTotal(){
        // returns the Material since creation in kg as a string with unit
        $count_material = \App\Prints::select('material_amount')->get();
        $count_material = $count_material->sum('material_amount');
        $count_material = (int)(0.5+(float)($count_material)/1000);
        $count_material = $count_material." kg";
        return $count_material;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if all current jobs are finished
        $printers_busy = printers::where('in_use','=', 1)->get();
        foreach ($printers_busy as $printer_busy) {
            $printer_busy->changePrinterStatus($printers_busy);
        }

        // Get issues as a combination of printer issues and posts (workshop issues)
        $issues = $this->getIssues();

        // Get public and internal announcements
        $announcements =  Announcement::orderBy('created_at', 'desc')->take(20)->get();

        // Prints over last 12 months
        $count_prints = $this->getArrayPrintsLastMonths(12);
        $count_months = $this->getArrayLastMonths(12);
        $chart = $this->createChartPrintsLastMonths($count_prints,$count_months);
        
        // Users per year
        $count_users = $this->getUsersLastYear();

        // Material since creation
        $count_material = $this->getMaterialTotal();

        // Printer Availability
        $chart1 = $this->createChartPrinterAvailability();

        // Workshop Busy Periods
        $chartBusy = $this->createChartWorkshopUsage();

        return view('welcome.index', compact('issues','announcements', 'count_prints','count_months','count_users','count_material', 'chart', 'chart1','chartBusy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('welcome.index');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // Validate request from the form:

        $this -> validate(request(), [
            'title' => 'required|string|max:180|regex:/^[a-z A-Z0-9.,!?]+$/',
            'body' => 'required|string|max:300|regex:/^[a-z A-Z0-9.,!?]+$/'
        ]);

//        dd(request()->all());

//        auth()->user()->publish(
//            new welcome(request(['title','body']))
//
//        );

//        // Collect data from a post to submit to the database welcome:
//
        $post = new posts;
        $post -> title = request('title');
        $post -> body = request('body');
        $post -> staff_id = Auth::user()->staff->id;
        $post -> resolved = 0;

        // Submit the data to the database

        $post->save();

        $critical=Input::get('critical');
        if ($critical == 'critical')
        {
            $title = $post->title;
            $body = $post->body;
            $printers =  printers::pluck('id','id')->all();
            $post->delete();

            // Redirect to create issue
            return view('issues/select',compact('title','body', 'printers'));
        } else {

        // Notify and Return to the homepage:

            notify()->flash('The post has been created.', 'success', [
                'text' => "Please go to the posts if you want to add anything else.",
            ]);

        return redirect('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function show(posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\welcome  $welcome
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, posts $posts)
//    {
//        //
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\welcome  $welcome
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = posts::findOrFail($id);
        $post->delete();

        notify()->flash('The post has been deleted.', 'success', [
            'text' => "The post is removed from the database.",
        ]);
        return redirect('/');
    }
    public function resolve($id)
    {
        //$post = Posts::findOrFail($id);
        //dd($post->title);
        //$post->update(['resolved' => 1]);
        Posts::where('id', $id)->update(['resolved' => 1]);

        notify()->flash('The issue is resolved', 'success', [
            'text' => "The issue is marked as resolved and won't appear on the homepage anymore",
        ]);
        return redirect('/');
    }
}
