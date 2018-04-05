<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UoScontroller extends Controller
{
    public function requestAuthenticationFromUoS()
    {
//        $email =  Config::get('testGlobal.[MELLON_mail]');
//        dd($email);
        return view('auth.UoSlogin');
    }

//    public function receiveResponseFromUoS(Request $_SERVER)
//    {
//        // Validate the request
//        $this->validate($_SERVER, [
//            'MELLON_mail' => 'required'
//        ]);
//    }
}
