<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Hash;
use Auth;

/**
 * Class User
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
    
    // The function which shows the staff record connected user
    public function isCustomer(){
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        if($this->id != $SAMLpars['customer']['id']){
            return false;
        }
        return true;
    }
    
    /**returns the full name of that staff or customer**/
    public function name()
    {
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        if($this->id != $SAMLpars['customer']['id']){
            return $this->name;
        }
        return $_SERVER[$SAMLpars['name']];
    }
    /**returns the email of that staff or customer**/
    public function email()
    {
        $auth = config('auth');
        $SAMLpars = $auth['SAML'];
        if($this->id != $SAMLpars['customer']['id']){
            return $this->email;
        }
        return $_SERVER[$SAMLpars['email']];
    }
    
    // The function which allows a user to create a post
    public function publish(posts $post){

        // Saves a post
        $this->post()->save($post);

    }
    // The function which allows user to create comments
    public function addComment(comments $comment, $post){
        $comment = new comments;
        $comment -> body = request('body');
        $comment -> staff_id = Auth::user()->staff->id;
        $comment -> posts_id = $post->id;
        $comment -> save();
    }
    
}
