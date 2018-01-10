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
        // Validation rules for registration
        return Validator::make($data, [
            // Name contains up to 100 signs, normal and capital letters and hyphen
            'name' => 'required|string|max:100|regex:/^[a-z-A-Z- ]{3,20}$/',
            // Email contains up to 255 and is unique in user database
            'email' => 'required|string|email|max:255|unique:users',
            // Password min 6 max 16 is necessary to have capital letters, ordinary letters and digits, also it should be confirmed
            'password' => 'required|string|min:6|max:16|regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,16}$/|confirmed',
            // Student id is number and contains 8 or 9 digits
            'student_id' => 'required|numeric|min:8',
            // Phone number contains 11 digits
            'phone' => 'required|numeric|digits:11'
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
        // Create user with name, email and encrypted password from request
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    public function register(Request $request)
    {
        // Validate the request according to the rules in validator() function
        $this->validator($request->all())->validate();

        // Check weather the email is in the demonstrator database
        // Pluck all emails from the database and convert it into array
        $emails = staff::all()->pluck('email','id')->toArray();
        // Convert all emails to lower case
        $emails = array_map('strtolower', $emails);
        // Convert input email to lowercase
        $email = strtolower(request('email'));
        // Check if input variable $email is in array $emails
        if( in_array($email, $emails)) {

            // Create and save a new user
            event(new Registered($user = $this->create($request->all())));

            // Find the id of email in staff database
            $staff_id = array_search($email,$emails);
            // Update staff database
            staff::where('id','=',$staff_id)->update(array('user_id'=> $user->id, 'student_id' => request('student_id'), 'phone' => request('phone')));

            // Find member associated with $staff_id
            $member = staff::find($staff_id);

            // Update users role according to the role in staff database
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
            notify()->flash('Thank you for registering with the 3D printing workshop!', 'success', [
                'text' => 'You will receive the confirmation email shortly.',
            ]);
        } else {
            // If the email hasn't been found in the database do not register but notify the user
            event(new Registered($user = null));
            notify()->flash('Sorry, your email is not in the workshop staff list.', 'error', [
                'text' => 'If you are current demonstrator please contact the lead demonstrator.',
            ]);
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
