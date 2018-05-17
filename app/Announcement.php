<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Announcement
 * An announcement is a public or internal message.
 *
 * @package App
 * @property string $message the content of the announcement
 * @property boolean $public is this a public announcement?
 **/
class Announcement extends Model
{
    protected $guarded = [];
    
    //// CONNECTIONS TO OTHER MODELS/ SQL TABLE LINKS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** 
     * The user who posted this announcement
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
