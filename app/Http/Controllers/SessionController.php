<?php

namespace App\Http\Controllers;

use App\Sessions;
use App\Availability;
use App\staff;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\StatisticsHelper;
use Carbon\Carbon;
use Alert;

/**
 * This controller handles sessions when the printing service is open.
 * Sessions need to be created, updated and deleted. They also require assignment of demonstrators to them.
 *
 * A session is the smallest instance of the service work time. It has a start and an end time.
 * A session can be either public, meaning that anyone can attend it,
 * or private, meaning that only invited people should attend it.
 * Each session requires a certain number of demonstrators to run it.
 * All sessions in one day form a rota (See RotaController).
 **/
class SessionController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')->except('index');

    }

    /** prepare query for sessions for one day **/
    private function querySessionsForDate($date){
        $t1 = new Carbon($date.' 0:00:00');
        $t2 = new Carbon($date.' 23:59:59');
        $sessions = Sessions::where('start_date','>=',$t1)->where('start_date','<=',$t2);
        return $sessions;
    }

    /**takes a list of demonstrators and converts it into a list for a drop-down input**/
    private function pluckToList($demonstrators){
        $dems = [];
        foreach($demonstrators as $d){
            $dems[$d->id] = $d->first_name.' '.$d->last_name;
        }
        return $dems;
    }
    
    /**takes a list of demonstrators and orders them by how long it has been since they last demonstrated**/
    private function orderByLastSession($demonstrators){
        $temp = [];
        $dems = [];
        // Prepare array for sorting, by adding a new key
        foreach($demonstrators as $d){
            $lastsession = $d->lastSession();
            $dn = $d;
            $dn->lastsession = $lastsession;
            $temp[] = $dn;
        }
        // Do the sorting
        $temp = collect($temp)->sortBy('lastsession');
        $temp = $temp->values()->all();
        // $temp contains the demonstrators sorted by the last session they demonstrated - 
        // Now need to format for select form
        $dems = $this->pluckToList($temp);
        return $dems;
    }
    
    /** takes a list of staff and returns two list of staff,
        splitted by experience and order by last attended date
     **/
    private function splitByExperience($demonstrators){
        $demE = array();
        $demI = array();
        // Split into experienced and new demonstrators
        foreach($demonstrators as $dem){
            if($dem->isExperienced()){
                $demE[] = $dem;
            }else{
                $demI[] = $dem;
            }
        }
        // Order by date of last session asc
        $demE = $this->orderByLastSession($demE);
        $demI = $this->orderByLastSession($demI);
        $dems = [$demE,$demI];
        return $dems;
    }

    /** returns all the staff, that are tentatively available for that session and eligible to be assigned to a session **/
    private function getTentativeDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'tentative')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->get();
                //->where('SMT_date','!=', NULL)
        return $demonstrators;
    }
    
    /** returns all the staff, that are available for that session and eligible to be assigned to a session **/
    private function getAvailableDemonstratorsForSession($id){
        $demonstrators = staff::whereHas('availability', function ($query) use ($id) {
                $query->where('status', 'available')->where('sessions_id', $id);
                })
                ->where('role','!=', 'Former member')
                ->orderBy('last_name')
                ->get();
                //->where('SMT_date','!=', NULL)
        return $demonstrators;
    }

    /** get all sessions for one day **/
    public function getSessionsForDate($date){
        $sessions = $this->querySessionsForDate($date)->orderBy('start_date')->get();
        return $sessions;
    }

    /** get only the last session of a day **/
    public function getLastSessionForDate($date){
        $sessions = $this->querySessionsForDate($date)->orderBy('start_date','desc')->first();
        return $sessions;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    
    /** process request for new session display -> gets date from input and redirects to the appropriate session add/edit blade**/
    public function startcreate()
    {
        $this -> validate(request(), [
            'newdate' => 'required'
        ]);
        $date = request('newdate');
        return redirect('/rota/session/'.$date);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //dd(request()->all());
        $this -> validate(request(), [
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'num_dem' => 'required'
        ]);
        //convert time to date
        $date = request('date');
        $start_date = new Carbon($date.' '.request('start_time'));
        $end_date = new Carbon($date.' '.request('end_time'));

        if(request('session_public')=="isPublic")
        {
            $session_public = true;
        }else{
            $session_public = false;
        }

        $session = new sessions;
        $session -> start_date = $start_date;
        $session -> end_date = $end_date;
        $session -> dem_required = request('num_dem');
        $session->public = $session_public;

        // Submit the data to the database

        $session->save();
         
        // Show notification
        session()->flash('message', 'The session has been successfully added to the database!');
        //notify()->flash('The session has been successfully added to the database!', 'success', [
        //    'text' => 'please add more sessions or update existing sessions for this date.',
        //]);

        return redirect('/rota/session/'.$date);
    }

    /**Finds the shortest option list (Step 1)**/
    private function defaultSelectShortestList($sessions, $demonstrators, $defaults){
        //TODO: not yet done
        // For now: Find first unset default and return
        foreach($sessions as $s){
            $dem_id = 0;
            foreach($defaults['session_'.$s->id] as $def){
                if($def['id'] <= 0){
                    return [$s->id, $dem_id];
                }
                $dem_id++;
            }
        }
        return null;
    }
    
    /** Pick first option in demonstrator option list for the specified session and demonstrator (Step 2)**/
    private function defaultPickFist($session_id, $dem_id, $demonstrators){
        //Get the appropriate list
        if($dem_id <= 0){
            $temp = $demonstrators['session_'.$session_id]['dem1'];
        }else{
            $temp = $demonstrators['session_'.$session_id]['dem2'];
        }
        //get first entry
        $name = reset($temp);
        $id = key($temp);
        return array('name' => $name, 'id' => $id);
    }
    
    /**removes the chosen demonstrator from the option lists in the same session (Step 3)**/
    private function defaultRemoveFromSameSession($session, $demonstrators, $choice){
        $dem1 = $demonstrators['session_'.$session->id]['dem1'];
        unset($dem1[$choice]);
        $demonstrators['session_'.$session->id]['dem1'] = $dem1;

        $dem2 = $demonstrators['session_'.$session->id]['dem2'];
        unset($dem2[$choice]);
        $demonstrators['session_'.$session->id]['dem2'] = $dem2;
        
        return $demonstrators;
    }
    
    /**moves the specified staff to the bottom of every list it occurs (Step 4)**/
    private function defaultMoveToBottomOfLists($demonstrators, $staff_id){
        foreach($demonstrators as $session_id => $sdem){
            foreach($sdem as $dem_id => $dem){
                //if list contains staff
                if(array_key_exists($staff_id,$dem)){
                    //move staff to bottom of list
                    $staff_name = $dem[$staff_id];
                    unset($dem[$staff_id]);
                    $dem[$staff_id] = $staff_name;
                }
                $demonstrators[$session_id][$dem_id] = $dem;
            }
        }
        return $demonstrators;
    }
    
    /** check, if there are demonstrators allocated to a session and returns them as a default, otherwise returns empty (Step 0)**/
    private function defaultAssigned($sessions, $demonstrators)
    {
        //First step: check, if there are already demonstrators allocated
        $defaults = [];
        foreach($sessions as $s){
            $staffs = $s->staff;
            for($d=0;$d<$s->dem_required;$d++){
                if(count($staffs) > $d){
                    // Default choice should be previously assigned demonstrator
                    $staff = $staffs[$d];
                    $defaults['session_'.$s->id]['dem_'.$d] = array('name' => $staff->first_name.' '.$staff->last_name, 'id' => $staff->id);
                    $demonstrators = $this->defaultRemoveFromSameSession($s, $demonstrators, $staff->id);
                }else{
                    // No demonstrator allocated so far -> Default choice needs to be determined
                    $defaults['session_'.$s->id]['dem_'.$d] = array('name' => '', 'id' => 0);
                }
            }
        }
        return [$defaults,$demonstrators];
    }

    /** takes a list of sessions and demonstrators to choose for the sessions and returns the default choices 
     *  idea on how to approach this:
     *  1) select shortest option list, 
     *  2) pick first, 
     *  3) remove that entry from each list for same session, 
     *  4) move the entry to the bottom of every other list
     *  5) go back to step 1) until all lists are completed
     **/
    private function choosedefault($sessions, $demonstrators)
    {
        
        
        //0) check, if there are already demonstrators allocated
        $temp = $this->defaultAssigned($sessions, $demonstrators);
        $defaults = $temp[0];
        $demonstrators = $temp[1];
        //1) select shortest option list,
        $temp = $this->defaultSelectShortestList($sessions, $demonstrators, $defaults);
        while($temp != null){
            $session_id = $temp[0];
            $dem_id = $temp[1];
            //2) pick first,
            $defaults['session_'.$session_id]['dem_'.$dem_id] = $this->defaultPickFist($session_id, $dem_id, $demonstrators);
            //3) remove that entry from each list for same session,
            $staff_id = $defaults['session_'.$session_id]['dem_'.$dem_id]['id'];
            $session = Sessions::find($session_id);
            $demonstrators = $this->defaultRemoveFromSameSession($session, $demonstrators, $staff_id);
            //4) move the entry to the bottom of every other list
            $demonstrators = $this->defaultMoveToBottomOfLists($demonstrators, $staff_id);
            //5) go back to step 1) until all lists are completed
            $temp = $this->defaultSelectShortestList($sessions, $demonstrators, $defaults);
        }
        return $defaults;
    }
    
    /** shows blade that assigns demonstrators to the rota **/
    public function showassign($date)
    {
        $sessions = $this->getSessionsForDate($date);
        $demonstrators = array();
        // Go through sessions
        foreach($sessions as $s){
            $id = $s->id;
            // Get available and tentatively available demontrators
            $demA = $this->getAvailableDemonstratorsForSession($id);
            $demT = $this->getTentativeDemonstratorsForSession($id);
            // Split the lists depending on the experience and
            // sort them so the ones who have not demonstrated for
            // a long time appear at the top of the list
            $temp = $this->splitByExperience($demA);
            $demEA = $temp[0];
            $demIA = $temp[1];
            $temp = $this->splitByExperience($demT);
            $demET = $temp[0];
            $demIT = $temp[1];
            // Create two prioritised lists - one for the first demonstrator in the session, and one for the others.
            $demonstrators['session_'.$id]['dem1'] = $demEA+$demET+$demIA+$demIT; //EA>ET>IA>IT
            $demonstrators['session_'.$id]['dem2'] = $demIA+$demEA+$demIT+$demET; //IA>EA>IT>ET
        }
        //TODO: need to choose default
        $default = $this->choosedefault($sessions, $demonstrators);
        return view('rota.assign', compact('date','sessions','demonstrators','default'));
    }

    /** assigns demonstrators to the rota **/
    public function assign($date)
    {
        $sessions = $this->getSessionsForDate($date);
        foreach($sessions as $s){
            for($d=0;$d<$s->dem_required;$d++){
                $this -> validate(request(), [
                    'dem_'.$s->id.'_'.$d => 'required',
                ]);
            }
            // Remove old Assignments
            $session = Sessions::findOrFail($s->id);
            $session->staff()->detach();
            $session->save();
            // Do new Assignments
            for($d=0;$d<$session->dem_required;$d++){
                $staff = staff::findOrFail(request('dem_'.$session->id.'_'.$d));
                $session->staff()->attach($staff);
                $session->save();
            }
        }
        
        // Show notification
        session()->flash('message', 'Demonstrators have been assigned!');
        /*notify()->flash('Demonstrators have been assigned!', 'success', [
            'text' => 'The rota for '.$date.' has been completed. Please review your changes before sending the rota to the demonstrators.',
        ]);*/
        return redirect('/rota/assign/'.$date);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        // Need to get id from submit button...
        $id = (int)request('btn_update');
        // Check all fields have been filled
        $this -> validate(request(), [
            'date' => 'required',
            'start_time_'.$id => 'required',
            'end_time_'.$id => 'required',
            'num_dem_'.$id => 'required'
        ]);
        // Convert time to date
        $date = request('date');
        $start_date = new Carbon($date.' '.request('start_time_'.$id));
        $end_date = new Carbon($date.' '.request('end_time_'.$id));
        
        // Set isPublic according to user selection
        if(null !== request('public_'.$id))
        {
            $session_public = true;
        }else{
            $session_public = false;
        }
        
        // Perform update in database
        $session = Sessions::findOrFail($id);
        $session->update(array('start_date' => $start_date, 
                               'end_date' => $end_date, 
                               'dem_required' => request('num_dem_'.$id), 
                               'public' => $session_public));
        
        // Give user feedback
        session()->flash('message', 'The session has been successfully updated!');

        return redirect('/rota/session/'.$date);
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy($id)
    {
        $session = Sessions::findOrFail($id);
        // save edited date for redirect
        $date = new Carbon($session->start_date);
        $date = $date->toDateString();
        // delete related data and then the actual session
        $session->availability()->delete();
        $session->delete();
        // redirect
        return redirect('/rota/session/'.$date);
    }
}
