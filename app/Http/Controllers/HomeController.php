<?php

namespace App\Http\Controllers;

use Auth;
use App\Announcement;
use App\FaultData;
use App\posts;
use App\printers;
use App\PublicAnnouncements;
use App\StatisticsHelper;
use App\Http\Controllers\Traits\WorkshopTrait;
use App\Http\Requests;
use Illuminate\Http\Request;


/** The functions for this controller manage the homepage **/
class HomeController extends Controller
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
     * Show the application dashboard.
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
        
        //check longest not used printer        
        $lostPrinter = $stats->getLongNotSeenPrinter();

        return view('welcome.index', compact('issues', 'announcements', 'count_prints', 'count_months', 'count_users', 'count_material','workshopIsOpen','lostPrinter'));
        //return view('home');
    }
}
