<?php

namespace App\Http\Controllers;

use App\posts;
use App\comments;
use Auth;

class CommentsController extends Controller
{
    public function __construct()
    {

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
