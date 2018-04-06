<?php

namespace App\Http\Controllers;

use App\PublicAnnouncements;
use Illuminate\Http\Request;
use App\Announcement;
use App\User;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Mail\AnnouncementNew;
use App\Mail\Welcome;

class AnnouncementsController extends Controller
{
    /**
     * AnnouncementsController constructor.
     * This controller manges private announcements
     */
    public function __construct()
    {
        // The functions in this controller available only for authenticated users
        $this->middleware('auth');

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
    public function create()
    {
        //
    }

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
            $users = User::all();
            foreach ($users as $user) {
                \Mail::to($user)->send(new AnnouncementNew($user,$announcement));
            }
        }
        // Return to the homepage:
        return redirect('/');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
