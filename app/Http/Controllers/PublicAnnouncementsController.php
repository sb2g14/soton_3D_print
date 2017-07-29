<?php

namespace App\Http\Controllers;

use App\PublicAnnouncements;
use Illuminate\Http\Request;

class PublicAnnouncementsController extends Controller
{
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

        $public_announcement = new PublicAnnouncements;
        $public_announcement->message = request('message');
        $public_announcement->user_id = 0;

        // Submit the data to the database

        $public_announcement->save();

        // Return to the homepage:

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PublicAnnouncements  $publicAnnouncements
     * @return \Illuminate\Http\Response
     */
    public function show(PublicAnnouncements $publicAnnouncements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PublicAnnouncements  $publicAnnouncements
     * @return \Illuminate\Http\Response
     */
    public function edit(PublicAnnouncements $publicAnnouncements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PublicAnnouncements  $publicAnnouncements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublicAnnouncements $publicAnnouncements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PublicAnnouncements  $publicAnnouncements
     * @return \Illuminate\Http\Response
     */
    public function destroy(PublicAnnouncements $publicAnnouncements)
    {
        //
    }
}
