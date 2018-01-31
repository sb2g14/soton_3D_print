<?php

namespace App\Http\Controllers;

use App\posts;
use App\printers;
use App\Prints;
use App\Announcement;
use App\PublicAnnouncements;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use App\FaultData;

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
        for($i=0; $i<23; $i++){
            $t1str = $time->format('Y-m')."-01 00:00:00";
            $time = $time->subMonth();
            $t2str = $time->format('Y-m')."-01 00:00:00";
            $prints = \App\Prints::orderBy('created_at', 'desc')->where('created_at', '>', $t2str)
                ->where('created_at', '<', $t1str)->count();
            $count_prints[] = $prints;
            $count_months[] = new \Carbon\Carbon($t2str);
        }
        return view('welcome.index', compact('issues','announcements', 'count_prints','count_months'));
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
            $id = $post->id;
            $printers =  printers::pluck('id','id')->all();

            // Redirect to create issue
            return view('issues/select',compact('id','printers'));
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
    public function destroy(posts $posts)
    {
        //
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
