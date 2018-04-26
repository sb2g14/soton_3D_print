<?php

namespace App\Http\Controllers;

use Auth;
use App\Announcement;
use App\FaultData;
use App\posts;
use App\printers;
use App\Prints;
use App\PublicAnnouncements;
use App\StatisticsHelper;
//use App\Http\Controllers\Traits\WorkshopTrait;
use App\Rules\Printer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;



/**
 * This controller manages non-printer related issues also called posts.
 **/
class PostsController extends Controller
{
    //use WorkshopTrait;
    
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** Specify pages available to an unauthenticated user **/
    public function __construct()
    {

        $this->middleware('auth');

    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    
    /**
     * Store a newly created post (Non-Printer Issue) in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     **/
    public function store()
    {
        // Validate request from the form:

        $this -> validate(request(), [
            'title' => 'required|string|max:180|regex:/^[a-z A-Z0-9.,!?]+$/',
            'body' => 'required|string|max:300|regex:/^[a-z A-Z0-9.,!?]+$/'
        ]);

        // Collect data from a post to submit to the database:
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
     * Remove the specified post (non-printer related issue) from storage.
     *
     * @param  \App\welcome  $welcome
     * @return \Illuminate\Http\Response
     **/
    public function destroy($id)
    {
        $post = posts::findOrFail($id);
        $post->delete();

        notify()->flash('The post has been deleted.', 'success', [
            'text' => "The post is removed from the database.",
        ]);
        return redirect('/');
    }
    
    /** mark the specified post (non-printer related issue) as resolved **/
    public function resolve($id)
    {
        Posts::where('id', $id)->update(['resolved' => 1]);

        notify()->flash('The issue is resolved', 'success', [
            'text' => "The issue is marked as resolved and won't appear on the homepage anymore",
        ]);
        return redirect('/');
    }
}
