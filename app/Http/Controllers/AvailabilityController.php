<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Sessions;
use App\Availability;
use App\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\StatisticsHelper;
use Carbon\Carbon;
use App\Http\Controllers\RotaController;

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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($date)
    {

    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
 
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
