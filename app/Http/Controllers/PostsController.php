<?php

namespace App\Http\Controllers;

use App\posts;
use App\printers;
use App\Prints;
use App\Announcement;
use App\PublicAnnouncements;
use App\Rules\Printer;
use App\Http\Controllers\Traits\WorkshopTrait;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use App\FaultData;
use App\StatisticsHelper;

/**
 * This controller manages the homepage 
 * TODO: this should be moved into the HomeController! Only keep the actions for posts in this controller!
 **/
class PostsController extends Controller
{
    use WorkshopTrait;
    
    //// PRIVATE (HELPER) FUNCTIONS ////
    //--------------------------------------------------------------------------------------------------------------
    
    /** Getting post and fault data and combining it **/
    private function _getIssues(){
        // Get printer related issues
        $faults = FaultData::select('id', 'title', 'body', 'created_at', 'staff_id_created_issue as staff_id', 'printers_id')
        ->where('resolved', 0);
        // Get generic (non-printer related) issues
        $posts = Posts::addSelect('id', 'title', 'body', 'created_at', 'staff_id')->selectRaw('NULL AS printers_id')->where('resolved', 0);
        // Combine them
        $issues = $faults->unionAll($posts)->orderBy('created_at','desc')->get();
        return $issues;
    }
    
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** Specify pages available to an unauthenticated user **/
    public function __construct()
    {

        $this->middleware('auth')->except(['index']);

    }

    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     **/
    public function index()
    {
        // Check if all current jobs are finished
        $printers_busy = printers::where('in_use','=', 1)->get();
        foreach ($printers_busy as $printer_busy) {
            $printer_busy->changePrinterStatus($printers_busy);
        }

        // Get issues as a combination of printer issues and posts (workshop issues)
        $issues = $this->_getIssues();

        // Get public and internal announcements
        $announcements =  Announcement::orderBy('created_at', 'desc')->take(20)->get();

        //get Statistics
        $stats = new StatisticsHelper();
        
        // Prints over last 12 months
        $count_prints = $stats->getArrayPrintsLastMonths(12);
        $count_months = $stats->getArrayLastMonths(12);
        
        // Users per year
        $count_users = $stats->getUsersLastYear();

        // Material since creation
        $count_material = $stats->getMaterialTotal();
        
        // check if workshop is open right now
        $workshopIsOpen = $this->isOpen();

        return view('welcome.index', compact('issues', 'announcements', 'count_prints', 'count_months', 'count_users', 'count_material','workshopIsOpen'));
    }


    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    
    /**
     * Store a newly created issue in storage.
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
     * Remove the specified non-printer related issue from storage.
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
    
    /** mark the specified non-printer related issue as resolved **/
    public function resolve($id)
    {
        Posts::where('id', $id)->update(['resolved' => 1]);

        notify()->flash('The issue is resolved', 'success', [
            'text' => "The issue is marked as resolved and won't appear on the homepage anymore",
        ]);
        return redirect('/');
    }
}
