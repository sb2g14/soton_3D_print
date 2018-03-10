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
use App\StatisticsHelper;


class PostsController extends Controller
{
    // Specify pages available to an unauthenticated user

    public function __construct()
    {

        $this->middleware('auth')->except(['index','show']);

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

        //get Statistics
        $stats = new StatisticsHelper();
        
        // Prints over last 12 months
        $count_prints = $stats->getArrayPrintsLastMonths(12);
        $count_months = $stats->getArrayLastMonths(12);
        $chartY1 = $stats->createChartPrintsLastMonths($count_prints,$count_months);
        
        // Prints over 12 months for last 4 years
        $chartY2 = $stats->createChartPrintsLastYearsPerMonth(5);

        // Total Prints for last 4 years
        $chartY3 = $stats->createChartPrintsLastYears(5);

        //Users per Year since 2014
        $chartYU = $stats->createChartUsersLastYears();
        
        // Users per year
        $count_users = $stats->getUsersLastYear();
        
        // Printer Success Rate
        $chartPR = $stats->createChartReliabilityPerPrinterType();

        // Material since creation
        $count_material = $stats->getMaterialTotal();

        // Printer Availability
        $chart1 = $stats->createChartPrinterAvailability();

        // Workshop Busy Periods
        $chartBusy = $stats->createChartWorkshopUsage();

        return view('welcome.index', compact('issues','announcements', 'count_prints','count_months','count_users','count_material', 'chartY1', 'chartY2', 'chartY3', 'chartYU', 'chartPR', 'chart1','chartBusy'));
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
