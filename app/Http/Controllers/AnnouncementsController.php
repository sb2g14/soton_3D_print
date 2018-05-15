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
//            try{
                if(env('APP_URL') === 'http://localhost'){
                    // Only Svitlana and Andrew now for testing purposes
                    $staff = staff::where('role','IT')->orWhere('role','IT Manager')->get();
                }else{
                    // Send to all except for the Former members
                    $staff = staff::where('role','!=','Former member')->get();
                }
                // Send email to users
                foreach ($staff as $member) {
                    //$recipient = collect([['name'=>$member->name(), 'email' => $member->email]]);
                    Mail::to($member->email)->send(new AnnouncementNew($member, $announcement));
                }
                // Notify that the user of success
                notify()->flash('The email has been sent' , 'success', [
                    'text' => 'The announcement has been successfully sent to all 3D Printing workshop staff',
                ]);
//            }catch(\Exception $e){
//                notify()->flash('Error!', 'error', [
//                    'text' => 'There has been an error with our email server. Please send an email to anyone who should be contacted about this.',
//                ]);
//            }
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
