<?php

namespace App\Http\Controllers;

use App\posts;
use App\comments;
use Auth;

// This controller manages comments to posts (issues)
class CommentsController extends Controller
{
    //// GENERIC PUBLIC FUNCTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    public function __construct()
    {
        // The functions in this controller available only for authenticated users
        $this->middleware('auth');

    }

    //// CONTROLLER ACTIONS ////
    //---------------------------------------------------------------------------------------------------------------//
    
    /**saves a comment**/
    public function store(posts $post){

        // Validate requests:

        $this->validate(request(), ['body'=>'required|min:2',]);

        // Add comment:

        auth()->user()->addComment(
            new comments(request(['body'])), $post
        );

        notify()->flash('The comment has been added.', 'success', [
            'text' => "Please do back to the post to view the comments.",
        ]);

        return redirect()->home();
    }
    
    /**deletes a comment**/
    public function destroy($id){
        $comment = comments::findOrFail($id);
        $comment->delete();

        notify()->flash('The comment has been deleted.', 'success', [
            'text' => "The comment is removed from the database.",
        ]);
        return redirect('/');
    }
}
