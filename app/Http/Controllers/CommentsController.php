<?php

namespace App\Http\Controllers;

use App\posts;
use App\comments;
use Auth;

class CommentsController extends Controller
{
    // This controller manages comments to posts (issues)
    public function __construct()
    {
        // The functions in this controller available only for authenticated users
        $this->middleware('auth');

    }
    public function store(posts $post){

        // Validate requests:

        $this->validate(request(), ['body'=>'required|min:2',]);

        // Add comment:

        auth()->user()->addComment(
            new comments(request(['body'])), $post
        );
        return redirect()->home();
    }
}
