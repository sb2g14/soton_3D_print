<?php

namespace App\Http\Controllers;

use App\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;

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
        $members = staff::orderBy('first_name')->get();
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
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:11'
        ]);
        staff::create(request(['first_name', 'last_name', 'email', 'phone']),Input::get('role'));
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
            staff::where('id','=', $id)->update(array('role'=> Input::get('role')));
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
        session()->flash('message', 'The record has been deleted');

        return redirect('/aboutWorkshop');
    }
}
