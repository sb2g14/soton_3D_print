<?php

namespace App\Http\Controllers;

use App\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use App\Mail\Invitation;

class StaffController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = staff::orderBy('first_name')->where('role','!=', 'Former member')->get();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('members.create');
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:staff',
//            'phone' => 'required|numeric|digits:11'
        ]);
        $role = Input::get('role');
        $member = new staff;
        $member -> first_name = request('first_name');
        $member -> last_name = request('last_name');
        $member -> email = request('email');
//        $member -> phone = request('phone');
        $member -> role = $role;

        // Submit the data to the database

        $member->save();

        if(!empty($member->user)) {
            if ($role == 'Lead Demonstrator') {
                $member->user->assignRole('LeadDemonstrator');
            } elseif ($member->role == 'Former member') {
                $member->user->assignRole('OldDemonstrator');
            } elseif ($member->role == '3D Hub Manager') {
                $member->user->assignRole(['OnlineJobsManager','Demonstrator']);
            } elseif ($member->role == 'New Demonstrator') {
                $member->user->assignRole('NewDemonstrator');
            } else {
                $member->user->assignRole('Demonstrator');
            }
        }
        // Send an email to the customer
        \Mail::to($member->email)->queue(new Invitation($member->first_name));

        session()->flash('message', 'The record has been successfully added to the database!');

        return redirect('/members/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = staff::find($id);
        return view('members.show',compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = staff::find($id);
        return view('members.edit',compact('member'));
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'student_id' => 'required|numeric',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:11',
        ]);
        $student_id = (int) Input::get('student_id');
//        dd(request()->all(), $student_id);

        $member = staff::findOrFail($id);
        $member->update(request(['first_name', 'last_name', 'email', 'phone','student_id']));

        staff::where('id','=', $member->id)->update(array('student_id'=> $student_id));


        if(Auth::user()->hasAnyRole(['administrator','LeadDemonstrator']))
        {
            $role = Input::get('role');
            staff::where('id','=', $id)->update(array('role'=> $role));
            if(!empty($member->user)) {
                // Find the record associated with id in users table
                $user = $member->user;
                // Assign relevant role
                if($role == 'Lead Demonstrator') {
                    $user->syncRoles(['LeadDemonstrator']);
                }elseif($role == 'Former member'){
                    $user->syncRoles(['OldDemonstrator']);
                    staff::where('id','=', $id)->update(array('phone' => 'unknown'));
                }elseif($role == 'IT Manager' || $role == 'IT'){
                    $user->syncRoles(['administrator']);
                }elseif($role == '3D Hub Manager'){
                    $user->syncRoles(['OnlineJobsManager','Demonstrator']);
                }elseif($role == 'New Demonstrator') {
                    $user->syncRoles(['NewDemonstrator']);
                }elseif($role == 'Coordinator' || $role == 'Co-Coordinator') {
                    $user->syncRoles(['Coordinator']);
                }elseif($role == 'Technician') {
                    $user->syncRoles(['Technician']);
                }else{
                    $user->syncRoles(['Demonstrator']);
                }
            }
        }

        session()->flash('message', 'The record has been successfully updated!');

        return redirect('/members/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        staff::destroy($id);
        // Find the record associated with id in staff table
        $member = staff::find($id);
        if(!empty($member->user)) {
            // Find the record associated with id in users table
            $user = $member->user;
            // Assign role old demonstrator
            $user->syncRoles(['OldDemonstrator']);
        }
        // Update record in staff table
        staff::where('id','=', $id)->update(array('role'=> 'Former member', 'phone' => 'unknown'));
        session()->flash('message', 'The record has been deleted');

        return redirect('/members/index');
    }
    public function former()
    {
        $members = staff::orderBy('first_name')->where('role','=', 'Former member')->get();
        return view('members.former', compact('members'));
    }

    public function gettingPaid()
    {
        return view('gettingPaid');
    }

    public function documents()
    {
        return view('documents');
    }
}
