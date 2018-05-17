<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Messages
 * A message is part of a conversation between a customer and staff about a job.
 *
 * @package App
 * @property string $body content of the message
 **/
class Messages extends Model
{
    // fields of the form that are fillable
    protected $fillable = [
        'body'
    ];

    //// CONNECTIONS TO OTHER MODELS/ SQL TABLE LINKS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /** The function shows the job this message adresses **/
    public function job()
    {
        return $this->belongsTo(jobs::class);
    }
    
    /** The function shows the user who created this message **/
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }

    
}
