<?php

namespace App;

/**
 * Class comments
 * This class handles updates/ comments on generic (non-printer-related) issues (posts)
 *
 * @package App
 * @property string $body the content of the comment
 **/
class comments extends Model
{
    /** every comment is responding to a generic (non-printer-related) issues (post) **/
    public function posts() {
        return $this->belongsTo(posts::class);
    }
    
    /** every comment was created by a member of staff **/
    public function staff() {
        return $this->belongsTo(staff::class);
    }

    public function create(comments $comment){

//         Saves a post
//         $this->welcome()->save($post);


        // The other way to save a post
        $comment = new comments;
        $comment -> body = request('body');
        $comment -> staff_id = auth()->user()->staff->id;
        $comment -> posts_id = $this->welcome()->id;

        // Submit the data to the database

        $comment->save();
    }
}
