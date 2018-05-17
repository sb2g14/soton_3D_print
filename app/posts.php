<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class posts
 * This class handles generic (non printer-related) issues
 *
 * @package App
 * @property string $title title of the generic issue
 * @property string $body content of the generic issue
 * @property boolean $resolved has this issue been resolved?
 **/
class posts extends Model
{
    // fields of the form that are fillable
    protected $fillable = [
        'title',
        'body',
        'resolved'
    ];

    //// CONNECTIONS TO OTHER MODELS/ SQL TABLE LINKS ////
    //---------------------------------------------------------------------------------------------------------------//
    /** comments on this generic issue **/
    public function comments()
    {
        return $this->hasMany(comments::class);
    }
    
    /** member of staff who created this generic issue **/
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }
    
    /** ????? **/ //TODO: this function shouldn't be here, right?
    public function printer()
    {
        return $this->belongsTo(Printers::class,'printers_id');
    }
    
    //// OTHER FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    /** add a comment to this issue **/
    public function addComment($body)
    {
        $this->comments()->create(compact('body'));
    }
    
    
}
