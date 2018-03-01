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

//        $posts =  posts::orderBy('created_at', 'desc')->take(20)->get();
//        $posts -> toArray($posts);
//        $post_last = posts::orderBy('created_at','desc')->first();
        // Getting post and fault data and combining it
        $faults = FaultData::select('id', 'title', 'body', 'created_at', 'staff_id_created_issue as staff_id', 'printers_id')
        ->where('resolved', 0);
        $posts = Posts::addSelect('id', 'title', 'body', 'created_at', 'staff_id')->selectRaw('NULL AS printers_id')->where('resolved', 0);
        $issues = $faults->unionAll($posts)->orderBy('created_at','desc')->get();

        $announcements =  Announcement::orderBy('created_at', 'desc')->take(20)->get();

        // Call the prints model to extract statistical data
        $count_prints = [];
        $count_months = [];
        // Count the number of prints since the beginning of the current month
        $time = new \Carbon\Carbon;
        $t1str = $time->toDateTimeString();
        $t2str = $time->format('Y-m')."-01 00:00:00";
        $prints = \App\Prints::orderBy('created_at', 'desc')->where('created_at', '>', $t2str)
            ->where('created_at', '<', $t1str)->count();
        $count_prints[] = $prints;
        $count_months[] = new \Carbon\Carbon($t2str);
        // Count the number of prints for the last year
        for($i=0; $i<11; $i++){
            $t1str = $time->format('Y-m')."-01 00:00:00";
            $time = $time->subMonth();
            $t2str = $time->format('Y-m')."-01 00:00:00";
            $prints = \App\Prints::orderBy('created_at', 'desc')->where('created_at', '>', $t2str)
                ->where('created_at', '<', $t1str)->count();
            $count_prints[] = $prints;
            $count_months[] = new \Carbon\Carbon($t2str);
        }
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
        // Users per year
        $time = new \Carbon\Carbon;
        $t1str = $time->format('Y')."-01-01 00:00:00";
        $time = $time->subYear();
        $t2str = $time->format('Y')."-01-01 00:00:00";
        $count_users = \App\Jobs::where('created_at', '>', $t2str)
            ->where('created_at', '<', $t1str)->select('customer_id')->groupBy('customer_id')->get();
        $count_users = $count_users->count();
        // Material since creation
        $count_material = \App\Prints::select('material_amount')->get();
        $count_material = $count_material->sum('material_amount');
        $count_material = (int)(0.5+(float)($count_material)/1000);
        $count_material = $count_material." kg";
        // Printer Availability
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
        return view('welcome.index', compact('issues','announcements', 'count_prints','count_months','count_users','count_material', 'chart', 'chart1'));
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

        // Return to the homepage:

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
