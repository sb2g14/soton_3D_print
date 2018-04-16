<?php

namespace App\Http\Controllers;

use App\Availability;   //base model controlled
use App\Sessions;       //required to get all the sessions people an sign up for
//use App\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;               //required to get current user and related member of staff
use Carbon\Carbon;      //used to determine which sessions are in the future
use App\Http\Controllers\RotaController;    //used to convert sessions to rotas


/**
 * This controller handles the demonstrators availability.
 * After the Lead Demonstrator has created sessions, when the printing service should run (See session controller),
 * all demonstrators can enter their availability for these sessions. That way the Lead demonstrator can later assign
 * available demonstrators to the sessions.
 * An Availability is the status of one demonstrator for a particular Session. The status can be available, tentative, busy, or away.
 **/
class AvailabilityController extends Controller
{
    /**
     * AvailabilityController constructor.
     *
     */
    public function __construct()
    {

        $this->middleware('auth')->except('index');

    }
    
    
    
    private function getFutureSessions(){
        $t1 = new Carbon();
        $t2 = $t1->copy()->addMonths(2); //->where('availabilities.staff_id',$staffid)
        $sessions = Sessions::orderBy('start_date')
            ->where('start_date','>=',$t1->toDateTimeString())
            ->where('start_date','<=',$t2->toDateTimeString());
        return $sessions;
    }

    /**
     * Show the form for editing the availability
     */
    public function edit()
    {
        $staffid = Auth::user()->staff->id;
        $sessions = $this->getFutureSessions()->get();
            //->join('availabilities', 'sessions.id', '=', 'availabilities.sessions_id', 'left outer')
            //->get();
        $rc = new RotaController();
        $rotas = $rc->getRotas($sessions);
        
        $options = array('available'=>'available (I reserve this time in my calendar)','tentative'=>'tentative (only assign me, if necessary)','busy'=>"busy (I can't do this shift)",'away'=>"away (I can't be contacted during this time)");
        return view('rota.availability', compact('rotas','options','staffid'));
    }
    
    
    

    /**
     * Update the availability for the currently logged in staff
     *
     */
    public function update()
    {
        $staff = Auth::user()->staff;
        $sessions = $this->getFutureSessions()->get();
        foreach($sessions as $s){
            $this -> validate(request(), [
                'av_'.$s->id => 'required',
            ]);
        }
        // Remove old Availability for that user (this includes old records for historic sessions since no longer required)
        Availability::where('staff_id',$staff->id)->delete();
        // Add new availability
        foreach($sessions as $s){
            // Do new Assignments
            $a = new Availability;
            $a -> status = request('av_'.$s->id);
            $a -> staff_id = $staff->id;
            $a -> sessions_id = $s->id;
            // Submit the data to the database
            $a->save();
        }
        session()->flash('message', 'The availability has been successfully updated in the database!');
        
        return redirect('/rota/availability');
    }
}
