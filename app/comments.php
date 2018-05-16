<?php

namespace App;

/**
 * Class comments
 * This class handles updates/ comments on generic (non-printer-related) issues (posts)
 **/
class comments extends Model
{
    public function posts() {
        return $this->belongsTo(posts::class);
    }

    public function staff() {

        return $this->belongsTo(staff::class);

    }

    public function create(comments $comment){

//         Saves a post
//         $this->welcome()->save($post);


        // The other vay to save a post
        $comment = new comments;
        $comment -> body = request('body');
        $comment -> staff_id = auth()->user()->staff->id;
        $comment -> posts_id = $this->welcome()->id;

        // Submit the data to the database

        $comment->save();
    }
}
