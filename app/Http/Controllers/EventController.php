<?php

namespace App\Http\Controllers;

use App\Rota;
use App\Sessions;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\StatisticsHelper;
use Carbon\Carbon;

class EventController extends Controller
{
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

    }
    
    private function getEventTypeOptions(){
        $options = array('academic'=>'Academic (e.g. semesters, exam periods, etc)','holidays'=>'Student holidays','closure'=>'University closure period','internal'=>'Internal event (e.g. induction for first year students)');
        return $options;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sessions = $this->getFutureSessions()->get();
            //->join('availabilities', 'sessions.id', '=', 'availabilities.sessions_id', 'left outer')
            //->get();
        $options = $this->getEventTypeOptions();
        return view('rota.newevent', compact('sessions','options'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this -> validate(request(), [
            'event_type' => 'required',
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $event = new Event;
        $event -> start_date = request('start_date');
        $event -> end_date = request('end_date');
        $event -> name = request('event_name');
        $event -> type = request('event_type');

        // Submit the data to the database

        $event->save();
         
        session()->flash('message', 'The event has been successfully added to the database!');

        return redirect('/rota');
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
    
    /** get Sessions between now and the near future **/
    private function getFutureSessions(){
        $t1 = new Carbon();
        $t2 = $t1->copy()->addMonths(2); //->where('availabilities.staff_id',$staffid)
        $sessions = Sessions::orderBy('start_date')
            ->where('start_date','>=',$t1->toDateTimeString())
            ->where('start_date','<=',$t2->toDateTimeString());
        return $sessions;
    }

    /**
     * Show the form for editing the specified event.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::findorFail($id);
        $options = $this->getEventTypeOptions();
        return view('rota.updateevent', compact('event','options'));
    }
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this -> validate(request(), [
            'event_type' => 'required',
            'event_name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $start_date = request('start_date');
        $end_date = request('end_date');
        $event_type = request('event_type');
        $event_name = request('event_name');

        $event = Event::findorFail($id);

        // Submit the data to the database
        $event->update(array('start_date' => $start_date, 'end_date' => $end_date, 'name' => $event_name, 'type' => $event_type));
         
        session()->flash('message', 'The event has been successfully updated!');
        
        return redirect('/rota');
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
