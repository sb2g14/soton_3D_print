<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Carbon\Carbon;

/**
 * This controller handles events. 
 * An event is a special time period that has a start and an end date-time.
 * Events are independent from sessions and will mostly be public holidays and university key-dates.
 **/
class EventController extends Controller
{
    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** returns an array with the different event types and a description of them **/
    private function getEventTypeOptions(){
        $options = array('academic'=>'Academic (e.g. semesters, exam periods, etc)',
                        'holidays'=>'Student holidays',
                        'closure'=>'University closure period',
                        'internal'=>'Internal event (e.g. induction for first year students)');
        return $options;
    }
    
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = $this->getEventTypeOptions();
        return view('rota.newevent', compact('options'));
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
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Store a newly created event in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // Do PHP validation of HTML form
        $this -> validate(request(), [
            'event_type' => 'required',
            'event_name' => 'required|min:5|max:32',
            'start_date' => 'required|date_format:d/m/Y H:i',
            'end_date' => 'required|date_format:d/m/Y H:i'
        ]);
        
        // Create the Event instance
        $event = new Event;
        $event -> start_date = Carbon::createFromFormat('d/m/Y H:i',request('start_date'));
        $event -> end_date = Carbon::createFromFormat('d/m/Y H:i',request('end_date'));
        $event -> name = request('event_name');
        $event -> type = request('event_type');

        // Submit the data to the database
        $event->save();
         
        // Give user feedback
        notify()->flash('The event has been successfully added to the database!', 'success');

        return redirect('/rota');
    }

    /**
     * Update an event
     * Handles post send from rota/event/update/{id}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $this -> validate(request(), [
            'event_type' => 'required',
            'event_name' => 'required|min:5|max:32',
            'start_date' => 'required|date_format:d/m/Y H:i',
            'end_date' => 'required|date_format:d/m/Y H:i'
        ]);

        $start_date = Carbon::createFromFormat('d/m/Y H:i',request('start_date'));
        $end_date = Carbon::createFromFormat('d/m/Y H:i',request('end_date'));
        $event_type = request('event_type');
        $event_name = request('event_name');

        $event = Event::findorFail($id);

        // Submit the data to the database
        $event->update(array('start_date' => $start_date, 'end_date' => $end_date, 'name' => $event_name, 'type' => $event_type));

        // Give user feedback
        notify()->flash('The event has been successfully updated!', 'success');
        
        return redirect('/rota');
    }

    /**
     * Remove the specified event from storage.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: need to create function and button for deleting events
    }
}
