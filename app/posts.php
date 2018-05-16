<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class posts
 * This class handles generic (non printer-related) issues
 **/
class posts extends Model
{
    // The function states which fields of the form are fillable
    protected $fillable = [

        'title',
        'body'

    ];

    public function comments()

    {

        return $this->hasMany(comments::class);

    }
    // The function shows the user who created a post
    public function staff()
    {
        return $this->belongsTo(staff::class);
    }

    public function addComment($body)

    {

        $this->comments()->create(compact('body'));

    }
    public function printer()
    {
        return $this->belongsTo(Printers::class,'printers_id');
    }
}
