<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StatisticsController extends Controller
{
    
    /**
     * Show the statistics blade
     */
    public function show()
    {
        return view('statistics');
    }

    
}
?>
