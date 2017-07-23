<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addComment($body)

    {

        $this->comments()->create(compact('body'));

    }
}
