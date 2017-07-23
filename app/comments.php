<?php

namespace App;


class comments extends Model
{
    public function posts() {
        return $this->belongsTo(posts::class);
    }

    public function user() {

        return $this->belongsTo(User::class);

    }

    public function create(comments $comment){

        // Saves a post
        // $this->welcome()->save($post);


//        // The other vay to save a post
//        $comment = new comments;
//        $comment -> body = request('body');
//        $comment -> user_id = auth()->user()->id;
//        $comment -> posts_id = $this->welcome()->id;
//
//        // Submit the data to the database

//        $comment->save();
    }
}