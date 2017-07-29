<?php

namespace App\Http\Controllers;

use App\posts;
use App\printers;
use App\Announcement;
use App\PublicAnnouncements;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;

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

        $posts =  posts::orderBy('id', 'desc')->skip(1)->take(20)->get();
        $posts -> toArray($posts);
        $post_last = posts::orderBy('id','desc')->first();
        $announcements =  Announcement::orderBy('id', 'desc')->take(20)->get();

        $public_announcement_last = PublicAnnouncements::orderBy('id','desc')->first();
        $public_announcements =  PublicAnnouncements::orderBy('id', 'desc')->skip(1)->take(20)->get();
        return view('welcome.index', compact('posts','post_last','announcements','public_announcements','public_announcement_last'));
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
        $post -> user_id = Auth::user()->id;

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
    public function update(Request $request, posts $posts)
    {
        //
    }

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
}
