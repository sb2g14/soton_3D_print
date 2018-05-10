<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Messages extends Model
{
    // The function states which fields of the form are fillable
    protected $fillable = [
        
        'body'

    ];

    // The function shows the job this message adresses
    public function job()
    {
        return $this->belongsTo(jobs::class);
    }
    
    // The function shows the user who created a post
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }

    
}
