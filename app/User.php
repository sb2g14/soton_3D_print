<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Auth;

/**
 * Class User
 * All the people who have a log-in to the website are users.
 *
 * In contrast staff contains all the members of staff, even those 
 * who are not active users anymore or those that haven't registered 
 * yet.
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $fillable = ['name', 'email', 'password', 'remember_token'];
    
    
    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    
    // The function which shows the posts of a user
    public function post(){
        return $this->hasMany(posts::class);
    }
    
    // The function which shows the announcements of a user
    public function announcements(){
        return $this->hasMany(posts::class);
    }
    // The function which shows the announcements of a user
    public function publicAnnouncements(){
        return $this->hasMany(posts::class);
    }
    // The function which shows the comments of a user
    public function comments(){
        return $this->hasMany(comments::class);
    }
    // The function which shows the staff record connected user
    public function staff(){
        return $this->hasOne(staff::class);
    }
    // The function shows jobs approved by user
    public function printing_data(){
        return $this->hasMany(printing_data::class);
    }
    
    /** checks if a user is a customer or a member of staff and returns true or false **/
    public function isCustomer(){
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        if($this->id != $SAMLpars['customer']['id']){
            return false;
        }
        return true;
    }
    
    /**returns the given name of that staff or customer**/
    public function firstname()
    {
        // Load parameters
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        // Check if user is known to us as a member of staff
        if($this->id != $SAMLpars['customer']['id']){
            // Load the data from our database
            return $this->name; //TODO: split and take all but last
        }
        // If the user is a customer, we need to load the data from the SERVER variable
        $ans = "";
        // Go through all the different parameters that can encode the users first name
        foreach($SAMLpars['firstname'] as $code){
            if(isset($_SERVER[$code]) && $_SERVER[$code] != ""){
                $ans = $_SERVER[$code];
                break;
            }
        }
        return $ans;
    }
    
    /**returns the surname of that staff or customer**/
    public function lastname()
    {
        // Load parameters
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        // Check if user is known to us as a member of staff
        if($this->id != $SAMLpars['customer']['id']){
            // Load the data from our database
            return $this->name; //TODO: split and take last
        }
        // If the user is a customer, we need to load the data from the SERVER variable
        $ans = "";
        // Go through all the different parameters that can encode the users last name
        foreach($SAMLpars['lastname'] as $code){
            if(isset($_SERVER[$code]) && $_SERVER[$code] != ""){
                $ans = $_SERVER[$code];
                break;
            }
        }
        return $ans;
    }
    
    /**returns the full name of that staff or customer**/
    public function name()
    {
        // Load parameters
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        // Check if user is known to us as a member of staff
        if($this->id != $SAMLpars['customer']['id']){
            return $this->name;
        }
        // If the user is a customer, we need to load the data from the SERVER variable
        return $this->firstname().' '.$this->lastname();
    }
    
    /**returns all the emails of the user**/
    public function emails()
    {
        // Load parameters
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        $emails = [];
        // Check if user is known to us as a member of staff
        if($this->id != $SAMLpars['customer']['id']){
            // Add the data from our database
            $emails[] = $this->email;
        }
        // Go through all the different parameters that can encode the users email
        foreach($SAMLpars['email'] as $code){
            if(isset($_SERVER[$code]) && !in_array($_SERVER[$code],$emails) ){
                $emails[] = $_SERVER[$code];
                break;
            }
        }
        // If there is no email, we will return an empty string as an email - this is a dirty fix to prevent the email() function from crashing
        if(!$emails){
            $emails = ['']; //TODO: log-out user, since this must mean that the university server session expired! (This should probably happen in a more prominent place)
        }
        return $emails;
    }
    
    /**returns the email of that staff or customer**/
    public function email()
    {
        // Load parameters
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        // Check if user is known to us as a member of staff
        if($this->id != $SAMLpars['customer']['id']){
            return $this->email;
        }
        // If the user is a customer, we need to load the data from the SERVER variable
        $ans = $this->emails();
        return $ans[0];
    }
    
    /**The function which allows a user to create a post**/
    public function publish(posts $post){

        // Saves a post
        $this->post()->save($post);

    }
    /**The function which allows user to create comments**/
    public function addComment(comments $comment, $post){
        $comment = new comments;
        $comment -> body = request('body');
        $comment -> staff_id = Auth::user()->staff->id;
        $comment -> posts_id = $post->id;
        $comment -> save();
    }
    
}
