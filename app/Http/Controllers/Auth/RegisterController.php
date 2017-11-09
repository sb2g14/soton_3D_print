<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Mail\Welcome;
use App\staff;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:100|regex:/^[a-z-A-Z- ]{3,20}$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/|confirmed',
            'student_id' => 'required|numeric',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        // Check weather the email is in the demonstrator database
        $emails = staff::all()->pluck('email','id')->toArray();
        $emails = array_map('strtolower', $emails);
        $email = strtolower(request('email'));
        if( in_array($email, $emails)) {

            // Create ad save a new user
            event(new Registered($user = $this->create($request->all())));

            // Update staff database
            $staff_id = array_search($email,$emails);
            staff::where('id','=',$staff_id)->update(array('user_id'=> $user->id, 'student_id' => request('student_id')));

            $member = staff::find($staff_id);
            if($member->role == 'Lead Demonstrator') {
                $user->assignRole('LeadDemonstrator');
            }elseif($member->role == 'Former member'){
                $user->assignRole('OldDemonstrator');
            }elseif($member->role == 'IT Manager' || $member->role == 'IT'){
                $user->assignRole('administrator');
            }elseif($member->role == '3D Hub Manager'){
                $user->assignRole(['OnlineJobsManager','Demonstrator']);
            }elseif($member->role == 'New Demonstrator') {
                $user->assignRole('NewDemonstrator');
            }elseif($member->role == 'Coordinator' || $member->role == 'Co-Coordinator') {
                $user->assignRole('Coordinator');
            }elseif($member->role == 'Technician') {
                $user->assignRole('Technician');
            }else{
                $user->assignRole('Demonstrator');
            }

            // Sign then in
            $this->guard()->login($user);
            // Send an confirmation email

            \Mail::to($user)->send(new Welcome($user));

            // Snow a flashing message

            session()->flash('message', 'Thank you for registering with 3D printing workshop!');
            session()->flash('alert-class', 'alert-success');
        } else {
            event(new Registered($user = null));
            session()->flash('message', 'Sorry, your email is not in the workshop staff list.
                If you are current demonstrator please contact the lead demonstrator.');
            session()->flash('alert-class', 'alert-danger');
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
