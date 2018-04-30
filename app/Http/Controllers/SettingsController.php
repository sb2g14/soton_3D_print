<?php

namespace App\Http\Controllers;

use Auth;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;


/**
 * This controller handles rotas.
 * A rota is the collection of sessions for a day.
 *
 * This controller has functions to display a group of sessions, and to merge sessions into rotas and open-hours.
 **/
class SettingsController extends Controller
{

    //// PRIVATE (HELPER) FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    

    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
      
    public function __construct()
    {

        $this->middleware('auth');

    }

    
    
    
    //// CONTROLLER BLADES ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * Display all events and sessions from 2 weeks ago until eternity
     * sessions are grouped into rotas
     * rotas and events are merged into one list, sorted by start date
     */
    public function index()
    {
        
    }

    /**
     * Show the form for updating settings for the Rota.
     *
     * @return \Illuminate\Http\Response
     */
    public function editRota()
    {
        if(!Auth::check()) {
            abort(404);
        }
        
        $settingsAssignCheck = Settings::where('key','RotaCheckCWP')
                        ->orWhere('key','RotaCheckSMT')
                        ->orWhere('key','RotaCheckLWI')
                        ->get();
        
        return view('rota.settings', compact('settingsAssignCheck'));
    }
    
    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function updateRota()
    {
        $settingsAssignCheck = Settings::where('key','RotaCheckCWP')
                        ->orWhere('key','RotaCheckSMT')
                        ->orWhere('key','RotaCheckLWI')
                        ->get();
        
        foreach($settingsAssignCheck as $s){
            if(null !== request('setting_'.$s->id)){
                $check = True;
            }else{
                $check = False;
            }
            // Perform update in database
            $setting = Settings::findOrFail($s->id);
            $setting->update(array('value' => $check));
        }       

        notify()->flash('The settings have been updated' , 'success', []);

        return redirect('/rota/settings');
    }

    
}
