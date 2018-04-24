<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Announcement;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Mail\AnnouncementNew;
use App\staff;
use Illuminate\Support\Facades\Mail;

class AnnouncementsController extends Controller
{

    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**
     * AnnouncementsController constructor.
     * This controller manges private announcements
     */
    public function __construct()
    {
        // The functions in this controller available only for authenticated users
        $this->middleware('auth');

    }
    

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//

    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request from the form:

        $this->validate(request(), [
            'message' => 'required'
        ]);

        // Create the announcement and associate it with the user
        $announcement = new announcement;
        $announcement->message = request('message');
        $announcement->user_id = Auth::user()->id;
        $announcement->public = 0;

        // Duplicate post to public announcements if 'public' checked
        if (Input::get('public', false)) {
            $announcement->public = 1;
        }
        // Write the data to the database
        $announcement->save();

        if (Input::get('email', false)) {
            // Send the notification to users if the appropriate checkbox is checked
            // $users = User::all();
            // Only Svitlana and Andrew now for testing purposes
//            $users = staff::where('id',1)->orWhere('id',2)->pluck('email');
            // Send to all except for the Former members
            $users = staff::where('role','!=','Former member')->pluck('email');
            try{
                foreach ($users as $user) {
                    Mail::to($user)->send(new AnnouncementNew($user,$announcement));
                }
                // Notify that the user of success
                notify()->flash('The email has been sent' , 'success', [
                    'text' => 'The announcement has been successfully sent to all 3D Printing workshop staff',
                ]);
            }catch(\Exception $e){
                notify()->flash('Error!', 'error', [
                    'text' => 'There has been an error with our email server. Please send an email to anyone who should be contacted about this.',
                ]);
            }
        }


        // Return to the homepage:
        return redirect('/');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();

        notify()->flash('The announcement has been deleted.', 'success', [
            'text' => "The announcement is removed from the database.",
        ]);
        return redirect('/');
    }
}
